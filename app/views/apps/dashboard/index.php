<?php
// Set title untuk halaman
$title = 'Dashboard';

// Start session untuk flash messages
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Sample data untuk dashboard
$stats = [
    'total_orders' => 156,
    'total_revenue' => 'Rp 12.450.000',
    'total_products' => 45,
    'total_customers' => 89
];

$recent_orders = [
    ['id' => '#001', 'customer' => 'Siti Aminah', 'product' => 'Kue Ulang Tahun', 'amount' => 'Rp 350.000', 'status' => 'pending'],
    ['id' => '#002', 'customer' => 'Budi Santoso', 'product' => 'Roti Tawar', 'amount' => 'Rp 25.000', 'status' => 'completed'],
    ['id' => '#003', 'customer' => 'Maya Sari', 'product' => 'Cupcake Set', 'amount' => 'Rp 150.000', 'status' => 'processing'],
    ['id' => '#004', 'customer' => 'Ahmad Rizki', 'product' => 'Donat Coklat', 'amount' => 'Rp 45.000', 'status' => 'completed'],
];

// Content untuk dashboard
ob_start();
?>

<!-- Dashboard Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
            <p class="mt-1 text-sm text-gray-500">Selamat datang kembali! Berikut ringkasan bisnis Anda hari ini.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <button class="inline-flex items-center px-4 py-2 bg-soft-pink-500 hover:bg-soft-pink-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Produk Baru
            </button>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-6">Aksi Cepat</h3>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="<?= getBaseUrl() ?>/products/create" class="flex flex-col items-center p-4 bg-soft-pink-50 hover:bg-soft-pink-100 rounded-lg transition-colors duration-200 group">
            <div class="w-12 h-12 bg-soft-pink-500 group-hover:bg-soft-pink-600 rounded-lg flex items-center justify-center mb-3 transition-colors duration-200">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700 group-hover:text-soft-pink-600">Tambah Produk</span>
        </a>
        
        <a href="<?= getBaseUrl() ?>/orders" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200 group">
            <div class="w-12 h-12 bg-blue-500 group-hover:bg-blue-600 rounded-lg flex items-center justify-center mb-3 transition-colors duration-200">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600">Kelola Pesanan</span>
        </a>
        
        <a href="<?= getBaseUrl() ?>/users" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-200 group">
            <div class="w-12 h-12 bg-green-500 group-hover:bg-green-600 rounded-lg flex items-center justify-center mb-3 transition-colors duration-200">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700 group-hover:text-green-600">Lihat Pelanggan</span>
        </a>
    </div>
</div>

<?php
$content = ob_get_clean();

// Include layout app.php
include 'app/views/layouts/app.php';
?> 