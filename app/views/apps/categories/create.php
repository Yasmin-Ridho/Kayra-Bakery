<?php
// Set title untuk halaman
$title = 'Tambah Kategori';

// Start session untuk flash messages
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Content untuk create category
ob_start();
?>

<!-- Dashboard Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Kategori Baru</h1>
            <p class="mt-1 text-sm text-gray-500">Buat kategori baru untuk produk bakery Anda.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="<?= url('categories') ?>" 
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

<!-- Form Card -->
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-soft-pink-50">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Kategori</h3>
            <p class="mt-1 text-sm text-gray-600">Isi form di bawah untuk menambahkan kategori baru</p>
        </div>

        <form method="POST" action="<?= url('categories') ?>" class="p-6 space-y-6">
            <?= csrfField() ?>
            
            <!-- Nama Kategori -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="<?= old('name') ?>"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-soft-pink-500 focus:border-soft-pink-500 <?= hasValidationError('name') ? 'border-red-300 ring-red-500' : '' ?>"
                       placeholder="Contoh: Kue Ulang Tahun, Roti Manis, Pastry"
                       required>
                <?php if (hasValidationError('name')): ?>
                    <p class="mt-2 text-sm text-red-600"><?= getValidationError('name') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">Nama kategori yang akan ditampilkan kepada pelanggan</p>
            </div>

            <!-- Slug -->
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                    Slug <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="slug" 
                       name="slug" 
                       value="<?= old('slug') ?>"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-soft-pink-500 focus:border-soft-pink-500 <?= hasValidationError('slug') ? 'border-red-300 ring-red-500' : '' ?>"
                       placeholder="kue-ulang-tahun"
                       required>
                <?php if (hasValidationError('slug')): ?>
                    <p class="mt-2 text-sm text-red-600"><?= getValidationError('slug') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">URL-friendly version dari nama kategori (otomatis dibuat dari nama)</p>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="<?= url('categories') ?>" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-soft-pink-500 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-soft-pink-500 hover:bg-soft-pink-600 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-soft-pink-500 focus:ring-offset-2 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slug = name
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
        .replace(/\s+/g, '-') // Replace spaces with hyphens
        .replace(/-+/g, '-') // Replace multiple hyphens with single
        .trim('-'); // Remove leading/trailing hyphens
    
    document.getElementById('slug').value = slug;
});

// Auto-hide flash messages
setTimeout(function() {
    // Selector yang lebih spesifik untuk flash messages saja
    const alerts = document.querySelectorAll('.bg-red-50.border-red-200');
    alerts.forEach(alert => {
        // Pastikan ini benar-benar flash message dan bukan komponen lain
        if (alert && alert.querySelector('svg') && !alert.closest('button') && !alert.closest('a')) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 500);
        }
    });
}, 8000);

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const slug = document.getElementById('slug').value.trim();
    
    if (!name) {
        e.preventDefault();
        alert('Nama kategori wajib diisi!');
        document.getElementById('name').focus();
        return;
    }
    
    if (!slug) {
        e.preventDefault();
        alert('Slug kategori wajib diisi!');
        document.getElementById('slug').focus();
        return;
    }
});
</script>

<?php
$content = ob_get_clean();

// Include layout app.php
include 'app/views/layouts/app.php';
?>
