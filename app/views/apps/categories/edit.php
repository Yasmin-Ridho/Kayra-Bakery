<?php
// Set title untuk halaman
$title = 'Edit Kategori';

// Start session untuk flash messages
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Content untuk edit category
ob_start();
?>

<!-- Dashboard Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Kategori</h1>
            <p class="mt-1 text-sm text-gray-500">Ubah informasi kategori "<?= htmlspecialchars($category->name ?? '') ?>".</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <a href="<?= url('categories/' . ($category->id ?? '')) ?>" 
               class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Lihat Detail
            </a>
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
            <h3 class="text-lg font-semibold text-gray-900">Edit Informasi Kategori</h3>
            <p class="mt-1 text-sm text-gray-600">Ubah informasi kategori sesuai kebutuhan</p>
        </div>

        <form method="POST" action="<?= url('categories/' . ($category->id ?? '')) ?>" class="p-6 space-y-6">
            <?= csrfField() ?>
            <?= methodField('PUT') ?>
            
            <!-- Nama Kategori -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="<?= old('name', $category->name ?? '') ?>"
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
                       value="<?= old('slug', $category->slug ?? '') ?>"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-soft-pink-500 focus:border-soft-pink-500 <?= hasValidationError('slug') ? 'border-red-300 ring-red-500' : '' ?>"
                       placeholder="kue-ulang-tahun"
                       required>
                <?php if (hasValidationError('slug')): ?>
                    <p class="mt-2 text-sm text-red-600"><?= getValidationError('slug') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">URL-friendly version dari nama kategori</p>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <div class="flex items-center space-x-4">
                    <a href="<?= url('categories') ?>" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-soft-pink-500 transition-colors duration-200">
                        Batal
                    </a>
                    <button type="button" 
                            onclick="deleteCategory(<?= $category->id ?? 0 ?>, '<?= htmlspecialchars($category->name ?? '') ?>')"
                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus
                    </button>
                </div>
                <button type="submit" 
                        class="px-6 py-2 bg-soft-pink-500 hover:bg-soft-pink-600 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-soft-pink-500 focus:ring-offset-2 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Kategori
                </button>
            </div>
        </form>
    </div>

    <!-- Category Info Card -->
    <div class="mt-8 bg-gray-50 border border-gray-200 rounded-lg p-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-gray-800">Informasi Kategori</h3>
                <div class="mt-2 text-sm text-gray-600">
                    <ul class="space-y-1">
                        <li><strong>ID:</strong> <?= $category->id ?? 'N/A' ?></li>
                        <li><strong>Dibuat:</strong> <?= isset($category->created_at) ? formatDateIndonesian($category->created_at, 'd F Y H:i') : 'Tidak diketahui' ?></li>
                        <li><strong>Terakhir diubah:</strong> <?= isset($category->updated_at) ? formatDateIndonesian($category->updated_at, 'd F Y H:i') : 'Tidak diketahui' ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Hapus Kategori</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin menghapus kategori "<span id="categoryName" class="font-medium"></span>"? 
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form id="deleteForm" method="POST" class="inline">
                    <?= csrfField() ?>
                    <?= methodField('DELETE') ?>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-lg w-24 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 mr-2">
                        Hapus
                    </button>
                </form>
                <button onclick="closeDeleteModal()" 
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-lg w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-generate slug from name (only if slug is empty or matches current name)
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slugField = document.getElementById('slug');
    const currentName = '<?= $category->name ?? '' ?>';
    const currentSlug = '<?= $category->slug ?? '' ?>';
    
    // Only auto-generate if slug field is empty or still matches the original name pattern
    if (!slugField.value || slugField.value === currentSlug) {
        const slug = name
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
            .replace(/\s+/g, '-') // Replace spaces with hyphens
            .replace(/-+/g, '-') // Replace multiple hyphens with single
            .trim('-'); // Remove leading/trailing hyphens
        
        slugField.value = slug;
    }
});

// Delete functionality
function deleteCategory(id, name) {
    document.getElementById('categoryName').textContent = name;
    document.getElementById('deleteForm').action = '<?= url('categories') ?>/' + id;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
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
