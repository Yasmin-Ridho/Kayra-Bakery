<?php
$title = 'Pesanan Saya - Kayra Bakery & Cake';

// Helper function untuk mendapatkan base URL
if (!function_exists('getBaseUrl')) {
    function getBaseUrl() {
        $script_name = $_SERVER['SCRIPT_NAME'];
        $base_path = dirname($script_name);
        return $base_path === '/' ? '' : $base_path;
    }
}
$baseUrl = getBaseUrl();

// Start session untuk flash messages
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Helper function untuk status badge
function getStatusBadge($status) {
    switch ($status) {
        case 'pending':
            return '<span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 border border-yellow-300 shadow-sm">
                        <svg class="w-3 h-3 mr-1.5 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        Menunggu Verifikasi
                    </span>';
        case 'approved':
            return '<span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300 shadow-sm">
                        <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Disetujui
                    </span>';
        case 'rejected':
            return '<span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-300 shadow-sm">
                        <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        Ditolak
                    </span>';
        default:
            return '<span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 border border-gray-300 shadow-sm">
                        ' . ucfirst($status) . '
                    </span>';
    }
}

// Helper function untuk format tanggal Indonesia
function formatTanggalIndonesia($date) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    
    $timestamp = strtotime($date);
    $hari = date('d', $timestamp);
    $bulanNum = date('n', $timestamp);
    $tahun = date('Y', $timestamp);
    $jam = date('H:i', $timestamp);
    
    return $hari . ' ' . $bulan[$bulanNum] . ' ' . $tahun . ', ' . $jam . ' WIB';
}

ob_start();
?>

<!-- Hero Section with Gradient Background -->
<section class="relative py-16 sm:py-20 lg:py-24 bg-gradient-to-br from-soft-pink-100 via-pink-100 to-pink-200 overflow-hidden">
    <!-- Background Image Overlay -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-35" 
         style="background-image: url('https://images.unsplash.com/photo-1517433670267-08bbd4be890f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2126&q=80')"></div>
    
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-soft-pink-200/35 via-pink-100/25 to-pink-200/35"></div>
    
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-15">
        <div class="absolute top-10 left-10 w-32 h-32 bg-soft-pink-300 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-32 right-20 w-40 h-40 bg-pink-300 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute bottom-20 left-1/3 w-36 h-36 bg-soft-pink-400 rounded-full blur-3xl animate-pulse delay-2000"></div>
    </div>
    
    <!-- Floating Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-16 w-3 h-3 bg-white/50 rounded-full animate-float"></div>
        <div class="absolute top-40 right-20 w-4 h-4 bg-pink-300/60 rounded-full animate-float delay-1000"></div>
        <div class="absolute bottom-40 left-20 w-5 h-5 bg-soft-pink-400/50 rounded-full animate-float delay-2000"></div>
        <div class="absolute bottom-20 right-16 w-3 h-3 bg-white/60 rounded-full animate-float delay-3000"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <!-- Enhanced Breadcrumb -->
            <nav class="flex justify-center mb-8 sm:mb-10" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 md:space-x-4 text-sm bg-white/80 backdrop-blur-lg rounded-full px-6 py-3 shadow-xl border border-white/30">
                    <li class="inline-flex items-center">
                        <a href="<?= $baseUrl ?>/" class="text-gray-600 hover:text-soft-pink-600 transition-colors duration-200 flex items-center font-medium">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </li>
                    <li>
                        <span class="text-gray-800 font-bold">Pesanan Saya</span>
                    </li>
                </ol>
            </nav>
            
            <!-- Enhanced Title with Animation -->
            <div class="animate-fade-in-up">
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-gray-800 mb-6 sm:mb-8 leading-tight">
                    <span class="bg-gradient-to-r from-soft-pink-500 via-pink-500 to-pink-600 bg-clip-text text-transparent drop-shadow-sm">
                        Pesanan
                    </span>
                    <br class="hidden sm:block">
                    <span class="text-gray-700">Saya</span>
                </h1>
                
                <p class="text-lg sm:text-xl md:text-2xl lg:text-3xl text-gray-700 max-w-4xl mx-auto leading-relaxed px-4 font-medium mb-8">
                    Kelola dan pantau semua pesanan Anda dengan 
                    <span class="text-soft-pink-600 font-semibold">mudah</span> dalam 
                    <span class="text-pink-600 font-semibold">satu tempat</span>
                </p>
                
                <!-- Status Badge -->
                <div class="flex justify-center mb-8">
                    <div class="inline-flex items-center bg-gradient-to-r from-soft-pink-50 to-pink-50 border-2 border-soft-pink-200 rounded-full px-6 py-3 shadow-lg">
                        <svg class="w-5 h-5 text-soft-pink-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span class="text-soft-pink-700 font-semibold">Riwayat Pembelian</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Flash Messages -->
<?php if ($successMessage = getFlashMessage('success')): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-400 rounded-2xl p-6 shadow-xl animate-slide-in">
            <div class="flex items-center">
                <div class="flex-shrink-0 mr-4">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-base font-semibold text-green-800"><?= htmlspecialchars($successMessage) ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($errorMessage = getFlashMessage('error')): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="bg-gradient-to-r from-red-50 to-red-50 border-l-4 border-red-400 rounded-2xl p-6 shadow-xl animate-slide-in">
            <div class="flex items-center">
                <div class="flex-shrink-0 mr-4">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-base font-semibold text-red-800"><?= htmlspecialchars($errorMessage) ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Orders Content -->
<section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Orders Header with Stats -->
        <div class="mb-12">
            <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                <div class="px-8 py-8 border-b border-gray-200 bg-gradient-to-r from-soft-pink-50 via-pink-50 to-soft-pink-100">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="mb-6 lg:mb-0">
                            <h2 class="text-2xl font-bold text-gray-800 flex items-center mb-2">
                                <div class="w-12 h-12 bg-gradient-to-r from-soft-pink-500 to-pink-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                Riwayat Pesanan
                            </h2>
                            <p class="text-gray-600 ml-16">
                                <?php if (!empty($transactions)): ?>
                                    Anda memiliki <?= count($transactions) ?> pesanan
                                <?php else: ?>
                                    Belum ada pesanan yang dibuat
                                <?php endif; ?>
                            </p>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="<?= $baseUrl ?>/products" 
                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-soft-pink-500 to-pink-600 text-white font-semibold rounded-xl hover:from-soft-pink-600 hover:to-pink-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                Belanja Sekarang
                            </a>
                            <a href="<?= $baseUrl ?>/carts" 
                               class="inline-flex items-center px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-soft-pink-300 hover:text-soft-pink-600 transition-all duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8"/>
                                </svg>
                                Lihat Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <?php if (!empty($transactions)): ?>
            <div class="space-y-6">
                <?php foreach ($transactions as $transaction): ?>
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.02]">
                        <!-- Transaction Header -->
                        <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                <div class="mb-4 lg:mb-0">
                                    <div class="flex items-center mb-2">
                                        <h3 class="text-xl font-bold text-gray-800 mr-4">
                                            Pesanan #<?= $transaction->id ?>
                                        </h3>
                                        <?= getStatusBadge($transaction->status) ?>
                                    </div>
                                    <p class="text-sm text-gray-600">
                                        <?= formatTanggalIndonesia($transaction->created_at) ?>
                                    </p>
                                </div>
                                
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                    <div class="text-right">
                                        <div class="text-sm text-gray-600 font-medium">Total Pembayaran</div>
                                        <div class="text-2xl font-bold bg-gradient-to-r from-soft-pink-600 to-pink-600 bg-clip-text text-transparent">
                                            Rp <?= number_format($transaction->total_price, 0, ',', '.') ?>
                                        </div>
                                    </div>
                                    
                                    <a href="<?= $baseUrl ?>/transactions/<?= $transaction->id ?>" 
                                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Transaction Items Preview -->
                        <div class="p-8">
                            <?php 
                            // Get transaction items - pastikan menggunakan property yang benar
                            $transactionItems = $transaction->items;
                            $itemCount = count($transactionItems);
                            ?>
                            
                            <div class="flex items-center justify-between mb-6">
                                <h4 class="text-lg font-bold text-gray-800 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-soft-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    Item Pesanan
                                </h4>
                                <span class="text-sm font-semibold text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                                    <?= $itemCount ?> item
                                </span>
                            </div>
                            
                            <?php if (!empty($transactionItems)): ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <?php 
                                    $displayItems = array_slice($transactionItems, 0, 3); // Show max 3 items
                                    foreach ($displayItems as $item): 
                                        // Akses product dari attributes TransactionItem
                                        $product = null;
                                        if (isset($item->product) && $item->product) {
                                            $product = $item->product;
                                        }
                                        
                                        // Skip jika product tidak ada
                                        if (!$product) {
                                            continue;
                                        }
                                    ?>
                                        <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                            <img class="h-12 w-12 rounded-lg object-cover border border-gray-200" 
                                                 src="<?= htmlspecialchars($product->image ?? '') ?>" 
                                                 alt="<?= htmlspecialchars($product->name ?? 'Product') ?>"
                                                 onerror="this.src='<?= $baseUrl ?>/assets/images/placeholder-product.jpg'">
                                            <div class="flex-1 min-w-0">
                                                <h5 class="text-sm font-semibold text-gray-800 truncate">
                                                    <?= htmlspecialchars($product->name ?? 'Unknown Product') ?>
                                                </h5>
                                                <p class="text-xs text-gray-600">
                                                    <?= $item->quantity ?? 0 ?>x - Rp <?= number_format($item->total_price ?? 0, 0, ',', '.') ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    
                                    <?php if ($itemCount > 3): ?>
                                        <div class="flex items-center justify-center p-4 bg-gradient-to-r from-soft-pink-50 to-pink-50 rounded-xl border-2 border-dashed border-soft-pink-200">
                                            <div class="text-center">
                                                <div class="text-lg font-bold text-soft-pink-600">
                                                    +<?= $itemCount - 3 ?>
                                                </div>
                                                <div class="text-xs text-soft-pink-500 font-medium">
                                                    item lainnya
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">Tidak ada item dalam pesanan ini</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="text-center py-16 px-8">
                    <div class="w-24 h-24 bg-gradient-to-r from-soft-pink-100 to-pink-100 rounded-full flex items-center justify-center mx-auto mb-8">
                        <svg class="w-12 h-12 text-soft-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Belum Ada Pesanan</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto leading-relaxed">
                        Anda belum memiliki pesanan apapun. Mulai berbelanja sekarang dan nikmati produk-produk terbaik dari Kayra Bakery!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="<?= $baseUrl ?>/products" 
                           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-soft-pink-500 to-pink-600 text-white font-bold rounded-2xl hover:from-soft-pink-600 hover:to-pink-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Mulai Belanja
                        </a>
                        <a href="<?= $baseUrl ?>/" 
                           class="inline-flex items-center px-8 py-4 border-2 border-gray-300 text-gray-700 font-bold rounded-2xl hover:bg-gray-50 hover:border-soft-pink-300 hover:text-soft-pink-600 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Enhanced CSS & JavaScript -->
<style>
/* Enhanced animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out;
}

.animate-slide-in {
    animation: slideIn 0.6s ease-out;
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

/* Animation delays */
.delay-1000 { animation-delay: 1000ms; }
.delay-2000 { animation-delay: 2000ms; }
.delay-3000 { animation-delay: 3000ms; }

/* Truncate utility */
.truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Min width utility */
.min-w-0 {
    min-width: 0;
}

/* Enhanced scrollbar */
::-webkit-scrollbar {
    width: 10px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 6px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #f472b6, #ec4899);
    border-radius: 6px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #ec4899, #db2777);
}

/* Enhanced responsive utilities */
@media (max-width: 640px) {
    .sticky {
        position: relative !important;
        top: auto !important;
    }
}

/* Enhanced backdrop blur */
.backdrop-blur-sm {
    backdrop-filter: blur(4px);
}
</style>

<script>
// Enhanced page load animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe all cards
    document.querySelectorAll('.bg-white').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
        observer.observe(card);
    });
});

// Enhanced smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>

<?php
$content = ob_get_clean();
require_once 'app/views/layouts/landing.php';
?>
