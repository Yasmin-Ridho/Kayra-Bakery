<?php
// Set title untuk halaman
$title = 'Detail User';

// Start session untuk flash messages
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Content untuk show user
ob_start();
?>

<!-- Dashboard Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail User</h1>
            <p class="mt-1 text-sm text-gray-500">Informasi lengkap pengguna sistem.</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <a href="<?= url('users/' . $user->id . '/edit') ?>" 
               class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit User
            </a>
            <a href="<?= url('users') ?>" 
               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>
</div>

<!-- Flash Messages -->
<?php if ($successMessage = getFlashMessage('success')): ?>
    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800"><?= htmlspecialchars($successMessage) ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Main User Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <!-- User Header -->
    <div class="px-6 py-6 bg-gradient-to-r from-soft-pink-50 to-pink-50 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center space-x-4">
                <div class="h-20 w-20 rounded-full bg-gradient-to-r from-soft-pink-300 to-pink-400 flex items-center justify-center">
                    <span class="text-2xl font-bold text-white">
                        <?= strtoupper(substr($user->name ?? $user->email, 0, 1)) ?>
                    </span>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900"><?= htmlspecialchars($user->name ?? 'Tanpa Nama') ?></h2>
                    <p class="text-sm text-gray-600"><?= htmlspecialchars($user->email) ?></p>
                    <div class="mt-2">
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                            <?= ($user->role ?? '') === 'admin' 
                                ? 'bg-blue-100 text-blue-800' 
                                : 'bg-green-100 text-green-800' ?>">
                            <?= ucfirst($user->role ?? 'user') ?>
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 sm:mt-0 flex space-x-2">
                <form action="<?= url('users/' . $user->id) ?>" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus User
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- User Details -->
    <div class="px-6 py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Basic Information -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">ID User</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?= $user->id ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?= htmlspecialchars($user->name ?? 'Tidak diisi') ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <a href="mailto:<?= htmlspecialchars($user->email) ?>" class="text-soft-pink-600 hover:text-soft-pink-800">
                                <?= htmlspecialchars($user->email) ?>
                            </a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Role</dt>
                        <dd class="mt-1">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                <?= ($user->role ?? '') === 'admin' 
                                    ? 'bg-blue-100 text-blue-800' 
                                    : 'bg-green-100 text-green-800' ?>">
                                <?= ucfirst($user->role ?? 'user') ?>
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- System Information -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Sistem</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Dibuat</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <?= $user->getCreatedAtFormatted() ?? 'Tidak tersedia' ?>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Terakhir Diupdate</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <?= $user->getUpdatedAtFormatted() ?? 'Tidak tersedia' ?>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status Akun</dt>
                        <dd class="mt-1">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Aktif
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Role Information Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Informasi Role</h3>
        <p class="mt-1 text-sm text-gray-500">Hak akses dan permission user dalam sistem.</p>
    </div>
    
    <div class="px-6 py-6">
        <?php if (($user->role ?? '') === 'admin'): ?>
            <div class="rounded-lg bg-blue-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Administrator</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Mengelola semua produk dan kategori</li>
                                <li>Melihat dan mengelola semua pesanan</li>
                                <li>Mengelola user dan permission</li>
                                <li>Mengakses dashboard analytics</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="rounded-lg bg-green-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">User</h3>
                        <div class="mt-2 text-sm text-green-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Melihat katalog produk</li>
                                <li>Melakukan pemesanan</li>
                                <li>Melihat riwayat pesanan pribadi</li>
                                <li>Mengelola profil pribadi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Action History Card (Optional - if you want to track user actions) -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
        <p class="mt-1 text-sm text-gray-500">Riwayat aktivitas user dalam sistem.</p>
    </div>
    
    <div class="px-6 py-6">
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada aktivitas</h3>
            <p class="mt-1 text-sm text-gray-500">Log aktivitas akan ditampilkan di sini ketika tersedia.</p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'app/views/layouts/app.php';
?>
