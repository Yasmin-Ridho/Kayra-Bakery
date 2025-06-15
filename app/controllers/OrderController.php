<?php

require_once 'core/Controller.php';
require_once 'app/models/Transaction.php';
require_once 'app/models/TransactionItem.php';
require_once 'app/models/Product.php';
require_once 'app/models/User.php';

class OrderController extends Controller
{
    /**
     * Show user's orders (my-order page)
     */
    public function myOrder()
    {
        // check if user is not admin
        if (getCurrentUser()['role'] != 'user') {
            setFlashMessage('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect(getBaseUrl() . '/orders');
            return;
        }

        // Check if user is logged in
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            return redirect(getBaseUrl() . '/login');
        }
        
        $userId = $_SESSION['user_id'];
        
        // Get user transactions with items
        $transactions = Transaction::where('user_id', $userId);
        
        // Get transaction items for each transaction
        foreach ($transactions as $transaction) {
            $transactionItems = TransactionItem::where('transaction_id', $transaction->id);
            
            // Get products for each item using the same approach as TransactionController
            $items = [];
            foreach ($transactionItems as $item) {
                $product = $item->product(); // Use the belongsTo relationship method
                if ($product) {
                    $item->product = $product; // Attach product to item
                    $items[] = $item;
                }
            }
            
            $transaction->items = $items;
        }
        
        // Sort transactions by created_at descending (newest first)
        usort($transactions, function($a, $b) {
            return strtotime($b->created_at) - strtotime($a->created_at);
        });
        
        $data = [
            'transactions' => $transactions
        ];
        
        return $this->view('apps/orders/my-order', $data);
    }
    
    /**
     * Show order detail (alias for transaction detail)
     */
    public function show($id)
    {
        // Redirect to transaction detail
        return redirect(getBaseUrl() . '/transactions/' . $id);
    }
    
    /**
     * List all orders (admin dashboard view)
     */
    public function index()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            return redirect(getBaseUrl() . '/login');
        }
        
        // Get all transactions with customer info and items
        $transactions = Transaction::all();
        
        // Get transaction items and customer info for each transaction
        foreach ($transactions as $transaction) {
            // Get customer info
            $user = User::find($transaction->user_id);
            if ($user) {
                $transaction->customer_name = $user->name;
                $transaction->customer_phone = $user->phone ?? '';
                $transaction->customer_email = $user->email ?? '';
            } else {
                $transaction->customer_name = 'Unknown Customer';
                $transaction->customer_phone = '';
                $transaction->customer_email = '';
            }
            
            // Get transaction items
            $transactionItems = TransactionItem::where('transaction_id', $transaction->id);
            
            // Get products for each item
            $items = [];
            foreach ($transactionItems as $item) {
                $product = $item->product(); // Use the belongsTo relationship method
                if ($product) {
                    $item->product = $product; // Attach product to item
                    $items[] = $item;
                }
            }
            
            $transaction->items = $items;
        }
        
        // Sort transactions by created_at descending (newest first)
        usort($transactions, function($a, $b) {
            return strtotime($b->created_at) - strtotime($a->created_at);
        });
        
        $data = [
            'transactions' => $transactions
        ];
        
        return $this->view('apps/orders/index', $data);
    }
    
    /**
     * Update order status (approve/reject)
     */
    public function updateStatus($id)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            return redirect(getBaseUrl() . '/login');
        }
        
        // Validate CSRF token
        if (!validateCsrfToken()) {
            setFlashMessage('error', 'Token keamanan tidak valid.');
            return redirect(getBaseUrl() . '/orders');
        }
        
        // Get transaction
        $transaction = Transaction::find($id);
        if (!$transaction) {
            setFlashMessage('error', 'Pesanan tidak ditemukan.');
            return redirect(getBaseUrl() . '/orders');
        }
        
        // Get new status from POST data
        $newStatus = $_POST['status'] ?? '';
        
        // Validate status
        if (!in_array($newStatus, ['approved', 'rejected'])) {
            setFlashMessage('error', 'Status tidak valid.');
            return redirect(getBaseUrl() . '/orders');
        }
        
        // Update transaction status
        $transaction->status = $newStatus;
        $transaction->updated_at = date('Y-m-d H:i:s');
        
        if ($transaction->save()) {
            $statusText = $newStatus === 'approved' ? 'disetujui' : 'ditolak';
            setFlashMessage('success', "Pesanan #$id berhasil $statusText.");
        } else {
            setFlashMessage('error', 'Gagal mengupdate status pesanan.');
        }
        
        return redirect(getBaseUrl() . '/orders');
    }
    
    /**
     * Export orders data (placeholder for future implementation)
     */
    public function export()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            return redirect(getBaseUrl() . '/login');
        }
        
        // For now, just redirect back with info message
        setFlashMessage('info', 'Fitur export data akan segera tersedia.');
        return redirect(getBaseUrl() . '/orders');
    }
} 