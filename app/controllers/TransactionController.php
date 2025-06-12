<?php

require_once 'core/Controller.php';
require_once 'app/models/Transaction.php';
require_once 'app/models/TransactionItem.php';

class TransactionController extends Controller
{
    /**
     * Show transaction detail
     */
    public function show($id)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            return redirect(getBaseUrl() . '/login');
        }
        
        $userId = $_SESSION['user_id'];
        
        // Get transaction
        $transaction = Transaction::find($id);
        
        if (!$transaction) {
            setFlashMessage('error', 'Transaksi tidak ditemukan');
            return redirect(getBaseUrl() . '/');
        }
        
        // Check if transaction belongs to current user, only if user is not admin
        if ($transaction->user_id != $userId && !($_SESSION['user_role'] == 'admin')) {
            setFlashMessage('error', 'Anda tidak memiliki akses ke transaksi ini');
            return redirect(getBaseUrl() . '/');
        }
        
        // Get transaction items
        $transactionItems = TransactionItem::where('transaction_id', $id);
        
        // Get products for each item
        $items = [];
        foreach ($transactionItems as $item) {
            $product = $item->product();
            if ($product) {
                $items[] = [
                    'item' => $item,
                    'product' => $product
                ];
            }
        }
        
        $data = [
            'transaction' => $transaction,
            'items' => $items
        ];
        
        return $this->view('apps/transactions/show', $data);
    }

    /**
     * List user transactions
     */
    public function index()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            return redirect(getBaseUrl() . '/login');
        }
        
        $userId = $_SESSION['user_id'];
        
        // Get user transactions
        $transactions = Transaction::where('user_id', $userId);
        
        $data = [
            'transactions' => $transactions
        ];
        
        return $this->view('apps/transactions/index', $data);
    }
} 