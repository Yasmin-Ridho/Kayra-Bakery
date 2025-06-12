<?php

require_once 'core/Controller.php';
require_once 'app/models/Cart.php';
require_once 'app/models/Transaction.php';
require_once 'app/models/TransactionItem.php';
require_once 'app/models/Product.php';
require_once 'core/Helpers.php';

class CheckoutController extends Controller
{
    /**
     * Show checkout form
     */
    public function index()
    {
        $userId = $_SESSION['user_id'];
        
        // Get cart items
        $carts = Cart::where('user_id', $userId);
        
        if (empty($carts)) {
            setFlashMessage('warning', 'Keranjang belanja Anda kosong. Silakan tambahkan produk terlebih dahulu.');
            return redirect(getBaseUrl() . '/carts');
        }
        
        // Calculate totals
        $totalPrice = 0;
        $totalItems = 0;
        $checkoutItems = [];
        
        foreach ($carts as $cart) {
            $product = $cart->product();
            if ($product && $product->stock >= $cart->quantity) {
                $subtotal = $product->price * $cart->quantity;
                $totalPrice += $subtotal;
                $totalItems += $cart->quantity;
                
                $checkoutItems[] = [
                    'cart' => $cart,
                    'product' => $product,
                    'subtotal' => $subtotal
                ];
            }
        }
        
        if (empty($checkoutItems)) {
            setFlashMessage('error', 'Tidak ada produk yang tersedia untuk checkout. Periksa stok produk.');
            return redirect(getBaseUrl() . '/carts');
        }
        
        $data = [
            'checkoutItems' => $checkoutItems,
            'totalPrice' => $totalPrice,
            'totalItems' => $totalItems
        ];
        
        return $this->view('apps/checkout/index', $data);
    }

    /**
     * Process checkout and create transaction
     */
    public function store()
    {
        try {
            $userId = $_SESSION['user_id'];
            
            // Validate payment proof upload
            if (!isset($_FILES['payment_proof']) || $_FILES['payment_proof']['error'] !== UPLOAD_ERR_OK) {
                setValidationError('payment_proof', 'Bukti transfer wajib diupload');
                return redirect(getBaseUrl() . '/checkout');
            }
            
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $fileType = $_FILES['payment_proof']['type'];
            
            if (!in_array($fileType, $allowedTypes)) {
                setValidationError('payment_proof', 'Format file harus berupa gambar (JPG, PNG, GIF)');
                return redirect(getBaseUrl() . '/checkout');
            }
            
            // Validate file size (max 5MB)
            $maxSize = 5 * 1024 * 1024; // 5MB
            if ($_FILES['payment_proof']['size'] > $maxSize) {
                setValidationError('payment_proof', 'Ukuran file maksimal 5MB');
                return redirect(getBaseUrl() . '/checkout');
            }
            
            // Get cart items
            $carts = Cart::where('user_id', $userId);
            
            if (empty($carts)) {
                setFlashMessage('error', 'Keranjang belanja kosong');
                return redirect(getBaseUrl() . '/carts');
            }
            
            // Calculate total and validate stock
            $totalPrice = 0;
            $validItems = [];
            
            foreach ($carts as $cart) {
                $product = $cart->product();
                if (!$product) {
                    continue;
                }
                
                if ($product->stock < $cart->quantity) {
                    setFlashMessage('error', "Stok produk {$product->name} tidak mencukupi");
                    return redirect(getBaseUrl() . '/carts');
                }
                
                $subtotal = $product->price * $cart->quantity;
                $totalPrice += $subtotal;
                $validItems[] = [
                    'cart' => $cart,
                    'product' => $product,
                    'subtotal' => $subtotal
                ];
            }
            
            if (empty($validItems)) {
                setFlashMessage('error', 'Tidak ada produk yang valid untuk checkout');
                return redirect(getBaseUrl() . '/carts');
            }
            
            // Upload payment proof
            $uploadDir = 'storage/payment_proofs/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileExtension = pathinfo($_FILES['payment_proof']['name'], PATHINFO_EXTENSION);
            $fileName = 'payment_' . $userId . '_' . time() . '.' . $fileExtension;
            $filePath = $uploadDir . $fileName;
            
            if (!move_uploaded_file($_FILES['payment_proof']['tmp_name'], $filePath)) {
                setFlashMessage('error', 'Gagal mengupload bukti transfer');
                return redirect(getBaseUrl() . '/checkout');
            }
            
            // Start database transaction
            DB()->beginTransaction();
            
            try {
                // Create transaction
                $transaction = Transaction::create([
                    'user_id' => $userId,
                    'payment_proof_file' => $fileName,
                    'status' => 'pending',
                    'total_price' => $totalPrice
                ]);
                
                if (!$transaction) {
                    throw new Exception('Gagal membuat transaksi');
                }
                
                $transactionId = $transaction->id;
                
                // Create transaction items and update stock
                $transactionItemModel = new TransactionItem();
                
                foreach ($validItems as $item) {
                    $cart = $item['cart'];
                    $product = $item['product'];
                    
                    // Create transaction item
                    $transactionItemModel->create([
                        'transaction_id' => $transactionId,
                        'product_id' => $product->id,
                        'quantity' => $cart->quantity,
                        'price' => $product->price,
                        'total_price' => $item['subtotal']
                    ]);
                    
                    // Update product stock
                    $newStock = $product->stock - $cart->quantity;
                    Product::updateById($product->id, ['stock' => $newStock]);
                }
                
                // Clear cart
                foreach ($carts as $cart) {
                    $cart->delete();
                }
                
                // Commit transaction
                DB()->commit();
                
                setFlashMessage('success', 'Pesanan berhasil dibuat! Kami akan memverifikasi pembayaran Anda dalam 1x24 jam.');
                return redirect(getBaseUrl() . '/transactions/' . $transactionId);
                
            } catch (Exception $e) {
                DB()->rollback();
                
                // Delete uploaded file if transaction failed
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                
                throw $e;
            }
            
        } catch (Exception $e) {
            setFlashMessage('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect(getBaseUrl() . '/checkout');
        }
    }
} 