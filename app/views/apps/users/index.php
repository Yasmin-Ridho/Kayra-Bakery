<?php
// Set title untuk halaman
$title = 'Manajemen User';

// Start session untuk flash messages
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Content untuk users
ob_start();
?>

<!-- Dashboard Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen User</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola pengguna sistem dengan mudah.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="<?= url('users/create') ?>" 
               class="inline-flex items-center px-4 py-2 bg-soft-pink-500 hover:bg-soft-pink-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah User
            </a>
        </div>
    </div>
</div>

<!-- Flash Messages -->
<?php if (hasValidationErrors()): ?>
    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
                <div class="mt-2 text-sm text-red-700">
                    <?php displayValidationErrors(); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

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

<?php if ($warningMessage = getFlashMessage('warning')): ?>
    <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-yellow-800"><?= htmlspecialchars($warningMessage) ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-soft-pink-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-soft-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total User</p>
                <p class="text-2xl font-bold text-gray-900"><?= count($users->items) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.25-2.25L21 7l-3 3m-3.75-3.75L8.25 12l2.25 2.25 7.5-7.5m-7.5 7.5L15 9"/>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Admin</p>
                <p class="text-2xl font-bold text-gray-900">
                    <?php 
                    $adminCount = 0;
                    if (!empty($users->items)) {
                        foreach ($users->items as $user) {
                            if (($user->role ?? '') === 'admin') {
                                $adminCount++;
                            }
                        }
                    }
                    echo $adminCount;
                    ?>
                </p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Customer</p>
                <p class="text-2xl font-bold text-gray-900">
                    <?php 
                    $userCount = 0;
                    if (!empty($users->items)) {
                        foreach ($users->items as $user) {
                            if (($user->role ?? '') === 'user') {
                                $userCount++;
                            }
                        }
                    }
                    echo $userCount;
                    ?>
                </p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Customer Baru Hari Ini</p>
                <p class="text-2xl font-bold text-gray-900">
                    <?php 
                    $todayCount = 0;
                    $today = date('Y-m-d');
                    if (!empty($users->items)) {
                        foreach ($users->items as $user) {
                            if (isset($user->created_at) && date('Y-m-d', strtotime($user->created_at)) === $today) {
                                $todayCount++;
                            }
                        }
                    }
                    echo $todayCount;
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex-1 max-w-lg">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" 
                       id="searchInput"
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-soft-pink-500 focus:border-soft-pink-500" 
                       placeholder="Cari user...">
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            <select id="roleFilter" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-soft-pink-500 focus:border-soft-pink-500">
                <option value="">Semua Role</option>
                <option value="admin">Admin</option>
                <option value="customer">Customer</option>
            </select>
            
            <button type="button" 
                    onclick="resetFilters()" 
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-soft-pink-500">
                Reset
            </button>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Daftar User</h3>
        <p class="mt-1 text-sm text-gray-500">
            Menampilkan <?= count($users->items) ?> dari <?= count($users->items) ?> user
        </p>
    </div>

    <?php if (empty($users->items)): ?>
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada user</h3>
            <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan user pertama.</p>
            <div class="mt-6">
                <a href="<?= url('users/create') ?>" 
                   class="inline-flex items-center px-4 py-2 bg-soft-pink-500 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-soft-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-soft-pink-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah User
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Dibuat
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($users->items as $user): ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-soft-pink-300 to-pink-400 flex items-center justify-center">
                                            <span class="text-sm font-medium text-white">
                                                <?= strtoupper(substr($user->name ?? $user->email, 0, 1)) ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= htmlspecialchars($user->name ?? 'Tanpa Nama') ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            ID: <?= $user->id ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= htmlspecialchars($user->email) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    <?= ($user->role ?? '') === 'admin' 
                                        ? 'bg-blue-100 text-blue-800' 
                                        : 'bg-green-100 text-green-800' ?>">
                                    <?= ($user->role ?? '') === 'admin' ? 'Admin' : 'Customer' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $user->getCreatedAtFormatted() ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="<?= url('users/' . $user->id) ?>" 
                                       class="text-soft-pink-600 hover:text-soft-pink-900 transition-colors duration-200"
                                       title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="<?= url('users/' . $user->id . '/edit') ?>" 
                                       class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                       title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="<?= url('users/' . $user->id) ?>" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                                title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination - hide for now since we're not implementing real pagination -->
        <!-- <?php if (false): ?> -->
        <!-- Pagination code here if needed -->
        <!-- <?php endif; ?> -->
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const roleFilter = document.getElementById('roleFilter');
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedRole = roleFilter.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const name = row.querySelector('td:first-child .text-sm.font-medium').textContent.toLowerCase();
            const email = row.querySelector('td:nth-child(2) .text-sm').textContent.toLowerCase();
            const role = row.querySelector('td:nth-child(3) span').textContent.toLowerCase();
            
            const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
            const matchesRole = selectedRole === '' || role.includes(selectedRole);
            
            if (matchesSearch && matchesRole) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    searchInput.addEventListener('input', filterTable);
    roleFilter.addEventListener('change', filterTable);
    
    window.resetFilters = function() {
        searchInput.value = '';
        roleFilter.value = '';
        filterTable();
    };
});
</script>

<?php
$content = ob_get_clean();
include 'app/views/layouts/app.php';
?>
