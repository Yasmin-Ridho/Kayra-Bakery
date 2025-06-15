<?php

require_once 'core/autoload.php';
require_once 'app/models/Cart.php';
require_once 'app/models/Product.php';
require_once 'app/models/User.php';

/**
 * Cart Controller
 * 
 * Controller untuk menangani halaman cart/keranjang belanja
 * Menggunakan base Controller class untuk helper methods
 */

class CartController extends Controller
{
    /**
     * Halaman index cart
     */
    public function index()
    {
        // check if user is not admin
        if (getCurrentUser()['role'] != 'user') {
            setFlashMessage('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect(getBaseUrl() . '/dashboard');
            return;
        }

        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        $user = getCurrentUser();
        
        // Get carts with pagination
        $carts = Cart::where('user_id', $user['id']);
        
        // Calculate totals
        $totalItems = 0;
        $totalPrice = 0;
        
        foreach ($carts as $cart) {
            $product = $cart->product();
            if ($product) {
                $totalItems += $cart->quantity;
                $totalPrice += ($product->price * $cart->quantity);
            }
        }

        $this->view('apps/carts/index', [
            'carts' => $carts,
            'totalItems' => $totalItems,
            'totalPrice' => $totalPrice
        ]);   
    }

    /**
     * Halaman create cart (form tambah ke cart)
     */
    public function create()
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        // Get all products for dropdown
        $products = Product::all();

        $this->view('apps/carts/create', [
            'products' => $products
        ]);
    }

    /**
     * Add product to cart
     */
    public function store()
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        $request = request();
        $user = getCurrentUser();

        // Validasi input
        $isValid = $request->validate([
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric|min:1'
        ], [
            'product_id.required' => 'Produk wajib dipilih.',
            'product_id.numeric' => 'Produk tidak valid.',
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.numeric' => 'Jumlah harus berupa angka.',
            'quantity.min' => 'Jumlah minimal 1.'
        ]);

        if (!$isValid) {
            redirect(url('products'));
            return;
        }

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Check if product exists
        $product = Product::find($productId);
        if (!$product) {
            setFlashMessage('error', 'Produk tidak ditemukan.');
            redirect(url('products'));
            return;
        }

        // Check stock availability
        if ($product->stock < $quantity) {
            setFlashMessage('error', 'Stok produk tidak mencukupi. Stok tersedia: ' . $product->stock);
            redirect(url('products/' . $productId));
            return;
        }

        try {
            // Check if product already in cart
            $existingCart = Cart::where('user_id', $user['id']);
            $existingCartItem = null;
            
            foreach ($existingCart as $cart) {
                if ($cart->product_id == $productId) {
                    $existingCartItem = $cart;
                    break;
                }
            }

            if ($existingCartItem) {
                // Update quantity if product already in cart
                $newQuantity = $existingCartItem->quantity + $quantity;
                
                // Check stock for new quantity
                if ($product->stock < $newQuantity) {
                    setFlashMessage('error', 'Stok produk tidak mencukupi. Stok tersedia: ' . $product->stock . ', sudah ada di keranjang: ' . $existingCartItem->quantity);
                    redirect(url('products/' . $productId));
                    return;
                }
                
                $existingCartItem->quantity = $newQuantity;
                $existingCartItem->save();
                
                setFlashMessage('success', 'Jumlah produk di keranjang berhasil diperbarui!');
            } else {
                // Add new item to cart
                $cartData = [
                    'user_id' => $user['id'],
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                Cart::create($cartData);
                setFlashMessage('success', 'Produk berhasil ditambahkan ke keranjang!');
            }

            // Clear old input
            Request::clearOld();
            
            redirect(url('carts'));
        } catch (Exception $e) {
            setFlashMessage('error', 'Gagal menambahkan produk ke keranjang: ' . $e->getMessage());
            redirect(url('products/' . $productId));
        }
    }

    /**
     * Update cart item quantity
     */
    public function update($id)
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        $request = request();
        $user = getCurrentUser();

        // Find cart item
        $cart = Cart::find($id);
        if (!$cart || $cart->user_id != $user['id']) {
            setFlashMessage('error', 'Item keranjang tidak ditemukan.');
            redirect(url('carts'));
            return;
        }

        // Validasi input
        $isValid = $request->validate([
            'quantity' => 'required|numeric|min:1'
        ], [
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.numeric' => 'Jumlah harus berupa angka.',
            'quantity.min' => 'Jumlah minimal 1.'
        ]);

        if (!$isValid) {
            redirect(url('carts'));
            return;
        }

        $quantity = $request->input('quantity');

        // Check product and stock
        $product = $cart->product();
        if (!$product) {
            setFlashMessage('error', 'Produk tidak ditemukan.');
            redirect(url('carts'));
            return;
        }

        if ($product->stock < $quantity) {
            setFlashMessage('error', 'Stok produk tidak mencukupi. Stok tersedia: ' . $product->stock);
            redirect(url('carts'));
            return;
        }

        try {
            $cart->quantity = $quantity;
            $cart->updated_at = date('Y-m-d H:i:s');
            $cart->save();

            // Clear old input
            Request::clearOld();
            
            setFlashMessage('success', 'Jumlah produk berhasil diperbarui!');
            redirect(url('carts'));
        } catch (Exception $e) {
            setFlashMessage('error', 'Gagal memperbarui jumlah produk: ' . $e->getMessage());
            redirect(url('carts'));
        }
    }

    /**
     * Remove item from cart
     */
    public function delete($id)
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        $user = getCurrentUser();

        // Find cart item
        $cart = Cart::find($id);
        if (!$cart || $cart->user_id != $user['id']) {
            setFlashMessage('error', 'Item keranjang tidak ditemukan.');
            redirect(url('carts'));
            return;
        }

        try {
            $product = $cart->product();
            $productName = $product ? $product->name : 'Produk';
            
            Cart::deleteById($id);
            setFlashMessage('success', $productName . ' berhasil dihapus dari keranjang!');
        } catch (Exception $e) {
            setFlashMessage('error', 'Gagal menghapus item dari keranjang: ' . $e->getMessage());
        }

        redirect(url('carts'));
    }

    /**
     * Clear all cart items for current user
     */
    public function clear()
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        $user = getCurrentUser();

        try {
            // Get all cart items for user
            $carts = Cart::where('user_id', $user['id']);
            
            if (empty($carts)) {
                setFlashMessage('warning', 'Keranjang sudah kosong.');
                redirect(url('carts'));
                return;
            }

            // Delete all cart items
            foreach ($carts as $cart) {
                Cart::deleteById($cart->id);
            }

            setFlashMessage('success', 'Keranjang berhasil dikosongkan!');
        } catch (Exception $e) {
            setFlashMessage('error', 'Gagal mengosongkan keranjang: ' . $e->getMessage());
        }

        redirect(url('carts'));
    }

    /**
     * Get cart count for current user (AJAX)
     */
    public function count()
    {
        // Check authentication
        if (!isLoggedIn()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'count' => 0]);
            return;
        }

        $user = getCurrentUser();
        $carts = Cart::where('user_id', $user['id']);
        
        $totalItems = 0;
        foreach ($carts as $cart) {
            $totalItems += $cart->quantity;
        }

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'count' => $totalItems]);
    }

    /**
     * Get cart items for dropdown (AJAX)
     */
    public function items()
    {
        // Check authentication
        if (!isLoggedIn()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'items' => [],
                'total' => 0,
                'message' => 'Anda harus login terlebih dahulu.'
            ]);
            return;
        }

        $user = getCurrentUser();
        $carts = Cart::where('user_id', $user['id']);
        
        $items = [];
        $totalPrice = 0;
        
        foreach ($carts as $cart) {
            $product = $cart->product();
            if ($product) {
                $subtotal = $product->price * $cart->quantity;
                $totalPrice += $subtotal;
                
                $items[] = [
                    'id' => $cart->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->getFormattedPrice(),
                    'product_image' => $product->getImageUrl(),
                    'quantity' => $cart->quantity,
                    'subtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.')
                ];
            }
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'items' => $items,
            'total' => 'Rp ' . number_format($totalPrice, 0, ',', '.'),
            'count' => count($items)
        ]);
    }

    /**
     * Add to cart via AJAX
     */
    public function addAjax()
    {
        // Check authentication
        if (!isLoggedIn()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Anda harus login terlebih dahulu.'
            ]);
            return;
        }

        $request = request();
        $user = getCurrentUser();

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        // Check if product exists
        $product = Product::find($productId);
        if (!$product) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Produk tidak ditemukan.'
            ]);
            return;
        }

        // Check stock availability
        if ($product->stock < $quantity) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi. Stok tersedia: ' . $product->stock
            ]);
            return;
        }

        try {
            // Check if product already in cart
            $existingCart = Cart::where('user_id', $user['id']);
            $existingCartItem = null;
            
            foreach ($existingCart as $cart) {
                if ($cart->product_id == $productId) {
                    $existingCartItem = $cart;
                    break;
                }
            }

            if ($existingCartItem) {
                // Update quantity
                $newQuantity = $existingCartItem->quantity + $quantity;
                
                if ($product->stock < $newQuantity) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => false,
                        'message' => 'Stok produk tidak mencukupi. Stok tersedia: ' . $product->stock . ', sudah ada di keranjang: ' . $existingCartItem->quantity
                    ]);
                    return;
                }
                
                $existingCartItem->quantity = $newQuantity;
                $existingCartItem->save();
            } else {
                // Add new item
                $cartData = [
                    'user_id' => $user['id'],
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                Cart::create($cartData);
            }

            // Get updated cart count
            $carts = Cart::where('user_id', $user['id']);
            $totalItems = 0;
            foreach ($carts as $cart) {
                $totalItems += $cart->quantity;
            }

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang!',
                'cart_count' => $totalItems
            ]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Gagal menambahkan produk ke keranjang: ' . $e->getMessage()
            ]);
        }
    }
}

?>