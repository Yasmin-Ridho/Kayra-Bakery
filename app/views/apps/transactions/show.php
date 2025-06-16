<?php
$title = 'Detail Transaksi - Kayra Bakery & Cake';

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
            return '<span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 border border-yellow-300 shadow-sm">
                        <svg class="w-4 h-4 mr-2 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        Menunggu Verifikasi
                    </span>';
        case 'approved':
            return '<span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Disetujui
                    </span>';
        case 'rejected':
            return '<span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-300 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        Ditolak
                    </span>';
        default:
            return '<span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 border border-gray-300 shadow-sm">
                        ' . ucfirst($status) . '
                    </span>';
    }
}

ob_start();
?>

<!-- Hero Section with Gradient Background -->
<section class="relative py-16 sm:py-20 lg:py-24 bg-gradient-to-br from-soft-pink-50 via-pink-50 to-pink-100 overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-10 left-10 w-32 h-32 bg-soft-pink-300 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-32 right-20 w-40 h-40 bg-pink-300 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute bottom-20 left-1/3 w-36 h-36 bg-soft-pink-400 rounded-full blur-3xl animate-pulse delay-2000"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <!-- Enhanced Breadcrumb -->
            <nav class="flex justify-center mb-8 sm:mb-10" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 md:space-x-4 text-sm bg-white/70 backdrop-blur-sm rounded-full px-6 py-3 shadow-lg">
                    <li class="inline-flex items-center">
                        <a href="<?= $baseUrl ?>/" class="text-gray-600 hover:text-soft-pink-600 transition-colors duration-200 flex items-center">
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
                        <a href="<?= $baseUrl ?>/orders/my-order" class="text-gray-600 hover:text-soft-pink-600 transition-colors duration-200">Transaksi</a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </li>
                    <li>
                        <span class="text-gray-800 font-semibold">Detail #<?= $transaction->id ?></span>
                    </li>
                </ol>
            </nav>
            
            <!-- Enhanced Title with Animation -->
            <div class="animate-fade-in-up">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-gray-800 mb-6 sm:mb-8">
                    <span class="bg-gradient-to-r from-soft-pink-500 via-pink-500 to-pink-600 bg-clip-text text-transparent">
                        Detail
                    </span>
                    <span class="text-gray-800">Transaksi</span>
                </h1>
                <p class="text-lg sm:text-xl lg:text-2xl text-gray-600 max-w-3xl mx-auto leading-relaxed px-4">
                    Informasi lengkap pesanan dan status pembayaran Anda dengan detail yang komprehensif
                </p>
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

<!-- Enhanced Transaction Detail Content -->
<section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 lg:gap-12">
            
            <!-- Transaction Info with Enhanced Design -->
            <div class="xl:col-span-2 space-y-8">
                <!-- Transaction Header Card -->
                <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden transform hover:scale-[1.02] transition-all duration-300">
                    <div class="px-8 py-8 border-b border-gray-200 bg-gradient-to-r from-soft-pink-50 via-pink-50 to-soft-pink-100">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                            <div class="mb-4 lg:mb-0">
                                <h3 class="text-2xl font-bold text-gray-800 flex items-center mb-2">
                                    <div class="w-12 h-12 bg-gradient-to-r from-soft-pink-500 to-pink-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    Transaksi #<?= $transaction->id ?>
                                </h3>
                                <p class="text-gray-600 ml-16">
                                    Dibuat pada <?= date('d F Y, H:i', strtotime($transaction->created_at)) ?> WIB
                                </p>
                            </div>
                            <div class="lg:ml-4">
                                <?= getStatusBadge($transaction->status) ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Transaction Info -->
                            <div class="space-y-6">
                                <h4 class="text-lg font-bold text-gray-800 flex items-center">
                                    <div class="w-8 h-8 bg-soft-pink-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-soft-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    Informasi Transaksi
                                </h4>
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                                        <span class="text-gray-600 font-medium">ID Transaksi:</span>
                                        <span class="font-bold text-gray-800 bg-white px-3 py-1 rounded-lg shadow-sm">#<?= $transaction->id ?></span>
                                    </div>
                                    <div class="flex justify-between items-center p-4 bg-gradient-to-r from-soft-pink-50 to-pink-50 rounded-xl border border-soft-pink-200">
                                        <span class="text-gray-600 font-medium">Total Pembayaran:</span>
                                        <span class="font-bold text-xl bg-gradient-to-r from-soft-pink-600 to-pink-600 bg-clip-text text-transparent">
                                            Rp <?= number_format($transaction->total_price, 0, ',', '.') ?>
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                                        <span class="text-gray-600 font-medium">Status:</span>
                                        <div><?= getStatusBadge($transaction->status) ?></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Timeline -->
                            <div class="space-y-6">
                                <h4 class="text-lg font-bold text-gray-800 flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    Timeline
                                </h4>
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                                        <span class="text-gray-600 font-medium">Dibuat:</span>
                                        <span class="font-semibold text-gray-800">
                                            <?= date('d/m/Y H:i', strtotime($transaction->created_at)) ?>
                                        </span>
                                    </div>
                                    <?php if ($transaction->updated_at != $transaction->created_at): ?>
                                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                                        <span class="text-gray-600 font-medium">Diperbarui:</span>
                                        <span class="font-semibold text-gray-800">
                                            <?= date('d/m/Y H:i', strtotime($transaction->updated_at)) ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Enhanced Order Items -->
                <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                    <div class="px-8 py-8 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                        <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            Item Pesanan
                        </h3>
                        <p class="text-gray-600 ml-16 mt-1"><?= count($items) ?> item dalam pesanan ini</p>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        <?php foreach ($items as $itemData): ?>
                            <?php 
                            $item = $itemData['item'];
                            $product = $itemData['product'];
                            ?>
                            <div class="p-6 hover:bg-gradient-to-r hover:from-gray-50 hover:to-soft-pink-50 transition-all duration-300">
                                <div class="flex items-start space-x-4">
                                    <!-- Product Image with Quantity Badge -->
                                    <div class="flex-shrink-0 relative">
                                        <img class="h-20 w-20 rounded-xl object-cover border-2 border-gray-200 shadow-sm" 
                                             src="<?= $product->getImageUrl() ?>" 
                                             alt="<?= htmlspecialchars($product->name) ?>"
                                             onerror="this.src='<?= $baseUrl ?>/assets/images/placeholder-product.jpg'">
                                        <!-- Quantity Badge -->
                                        <div class="absolute -top-2 -right-2 bg-gradient-to-r from-soft-pink-500 to-pink-600 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg min-w-[24px] text-center">
                                            <?= $item->quantity ?>x
                                        </div>
                                    </div>
                                    
                                    <!-- Product Info -->
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-lg font-bold text-gray-800 mb-2 truncate">
                                            <?= htmlspecialchars($product->name) ?>
                                        </h4>
                                        <p class="text-sm text-gray-600 mb-3 line-clamp-2 leading-relaxed">
                                            <?= htmlspecialchars($product->description) ?>
                                        </p>
                                        
                                        <!-- Price and Quantity Info -->
                                        <div class="grid grid-cols-2 gap-3 text-sm">
                                            <div class="bg-gray-50 px-3 py-2 rounded-lg">
                                                <span class="text-xs text-gray-500 font-medium block">Harga Satuan</span>
                                                <span class="font-bold text-gray-800">
                                                    Rp <?= number_format($item->price, 0, ',', '.') ?>
                                                </span>
                                            </div>
                                            <div class="bg-gray-50 px-3 py-2 rounded-lg">
                                                <span class="text-xs text-gray-500 font-medium block">Jumlah</span>
                                                <span class="font-bold text-gray-800">
                                                    <?= $item->quantity ?> item
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Subtotal -->
                                    <div class="text-right flex-shrink-0">
                                        <div class="text-xs text-gray-500 font-medium mb-1">Subtotal</div>
                                        <div class="text-xl font-bold bg-gradient-to-r from-soft-pink-600 to-pink-600 bg-clip-text text-transparent">
                                            Rp <?= number_format($item->total_price, 0, ',', '.') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Enhanced Payment Info Sidebar -->
            <div class="xl:col-span-1">
                <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden sticky top-8">
                    <!-- Enhanced Header -->
                    <div class="px-8 py-8 border-b border-gray-200 bg-gradient-to-r from-soft-pink-50 via-pink-50 to-soft-pink-100">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-soft-pink-500 to-pink-600 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            Bukti Pembayaran
                        </h3>
                    </div>
                    
                    <div class="p-8">
                        <!-- Enhanced Payment Proof -->
                        <?php if ($transaction->payment_proof_file): ?>
                            <div class="mb-8">
                                <h4 class="text-base font-bold text-gray-800 mb-4 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-soft-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    Bukti Transfer
                                </h4>
                                <div class="relative group cursor-pointer" onclick="openImageModal('<?= $baseUrl ?>/storage/payment_proofs/<?= htmlspecialchars($transaction->payment_proof_file) ?>')">
                                    <img src="<?= $baseUrl ?>/storage/payment_proofs/<?= htmlspecialchars($transaction->payment_proof_file) ?>" 
                                         alt="Bukti Transfer" 
                                         class="w-full rounded-2xl border-2 border-gray-200 shadow-lg hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 rounded-2xl transition-all duration-300 flex items-center justify-center">
                                        <div class="bg-white/90 backdrop-blur-sm rounded-full p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-lg">
                                            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-3 text-center font-medium">Klik untuk memperbesar gambar</p>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($_SESSION['user_role'] != 'admin') { ?>
                        <!-- Enhanced Status Info -->
                        <div class="mb-8 p-6 rounded-2xl border-2 border-dashed border-gray-200 bg-gradient-to-br from-gray-50 to-gray-100">
                            <h4 class="text-base font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-soft-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Status Pembayaran
                            </h4>
                            <div class="text-center space-y-4">
                                <?= getStatusBadge($transaction->status) ?>
                                <div class="text-sm text-gray-600 leading-relaxed">
                                    <?php if ($transaction->status === 'pending'): ?>
                                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                                            <p class="font-medium text-yellow-800">Pembayaran Anda sedang dalam proses verifikasi.</p>
                                            <p class="text-yellow-700 mt-1">Kami akan mengkonfirmasi dalam 1x24 jam.</p>
                                        </div>
                                    <?php elseif ($transaction->status === 'approved'): ?>
                                        <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                                            <p class="font-medium text-green-800">Pembayaran telah diverifikasi!</p>
                                            <p class="text-green-700 mt-1">Pesanan Anda sedang diproses.</p>
                                        </div>
                                    <?php elseif ($transaction->status === 'rejected'): ?>
                                        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                                            <p class="font-medium text-red-800">Pembayaran ditolak.</p>
                                            <p class="text-red-700 mt-1">Silakan hubungi customer service untuk informasi lebih lanjut.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php }  ?>


                        <!-- Enhanced Order Summary -->
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between items-center p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border border-gray-200">
                                <span class="text-sm text-gray-600 font-semibold">Total Item</span>
                                <span class="text-sm font-bold text-gray-800 bg-soft-pink-100 text-soft-pink-700 px-3 py-1.5 rounded-full">
                                    <?= count($items) ?> item
                                </span>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between items-center p-6 bg-gradient-to-r from-soft-pink-50 to-pink-50 rounded-2xl border-2 border-soft-pink-200 shadow-sm">
                                    <span class="text-lg font-bold text-gray-800">Total Pembayaran</span>
                                    <span class="text-xl font-bold bg-gradient-to-r from-soft-pink-600 to-pink-600 bg-clip-text text-transparent">
                                        Rp <?= number_format($transaction->total_price, 0, ',', '.') ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <?php if ($_SESSION['user_role'] != 'admin') { ?>
                        <!-- Enhanced Action Buttons -->
                        <div class="space-y-4">
                            <a href="<?= $baseUrl ?>/orders/my-order" 
                               class="block w-full text-center bg-gradient-to-r from-soft-pink-500 to-pink-600 text-white py-4 px-6 rounded-2xl font-bold hover:from-soft-pink-600 hover:to-pink-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Lihat Semua Transaksi
                            </a>

                            <a href="<?= $baseUrl ?>/products" 
                               class="block w-full text-center border-2 border-gray-300 text-gray-700 py-4 px-6 rounded-2xl font-bold hover:bg-gray-50 hover:border-soft-pink-300 hover:text-soft-pink-600 transition-all duration-300">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                Belanja Lagi
                            </a>
                        </div>
                        <?php }  ?>
                        
                        <!-- Enhanced Contact Info -->
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <div class="text-center">
                                <h4 class="text-base font-bold text-gray-800 mb-3">Butuh Bantuan?</h4>
                                <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                                    Hubungi customer service kami untuk informasi lebih lanjut tentang pesanan Anda
                                </p>
                                <div class="flex items-center justify-center space-x-4 text-sm">
                                    <a href="https://wa.me/6281234567890" class="flex items-center text-green-600 hover:text-green-700 bg-green-50 hover:bg-green-100 px-4 py-2 rounded-xl transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                        </svg>
                                        WhatsApp
                                    </a>
                                    <a href="mailto:info@kayrabakery.com" class="flex items-center text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-xl transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        Email
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-80 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center p-4">
    <div class="relative max-w-5xl max-h-full animate-zoom-in">
        <button onclick="closeImageModal()" class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors duration-200 bg-black/50 backdrop-blur-sm rounded-full p-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img id="modalImage" class="max-w-full max-h-full rounded-2xl shadow-2xl">
    </div>
</div>

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

@keyframes zoomIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out;
}

.animate-slide-in {
    animation: slideIn 0.6s ease-out;
}

.animate-zoom-in {
    animation: zoomIn 0.3s ease-out;
}

/* Line clamp utilities */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

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
#F08080
::-webkit-scrollbar-track {
    background:rgb(250, 107, 219);
    border-radius: 6px;
}

body.admin-view {
    background-color: #F08080 !important;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom,rgb(240, 143, 193), #ec4899);
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

/* Enhanced hover effects */
.group:hover .group-hover\:scale-105 {
    transform: scale(1.05);
}

/* Enhanced backdrop blur */
.backdrop-blur-sm {
    backdrop-filter: blur(4px);
}
</style>

<?php if ($_SESSION['user_role'] == 'admin'): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('admin-view');
        });
    </script>
<?php endif; ?>

<script>
// Enhanced image modal functionality
function openImageModal(src) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    
    modalImage.src = src;
    modal.classList.remove('hidden');
    
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
    
    // Add escape key listener
    document.addEventListener('keydown', handleEscapeKey);
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    
    // Restore body scroll
    document.body.style.overflow = 'auto';
    
    // Remove escape key listener
    document.removeEventListener('keydown', handleEscapeKey);
}

function handleEscapeKey(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
}

// Close modal on click outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
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
</script>

<?php
$content = ob_get_clean();
require_once 'app/views/layouts/landing.php';
?> 