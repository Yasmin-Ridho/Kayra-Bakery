<?php
// Set title untuk halaman
$title = 'Tambah Produk';

// Start session untuk flash messages
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Content untuk create product
ob_start();
?>

<!-- Dashboard Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Produk</h1>
            <p class="mt-1 text-sm text-gray-500">Buat produk bakery baru untuk toko Anda.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="<?= url('dashboard') ?>" 
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
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Informasi Produk</h3>
        <p class="mt-1 text-sm text-gray-500">Lengkapi informasi produk dengan detail yang akurat.</p>
    </div>
    
    <form action="<?= url('products') ?>" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
        <!-- Image Upload -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Gambar Produk
            </label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-soft-pink-400 transition-colors duration-200">
                <div class="space-y-1 text-center">
                    <div id="imagePreview" class="hidden">
                        <img id="previewImg" class="mx-auto h-32 w-32 object-cover rounded-lg" src="" alt="Preview">
                    </div>
                    <div id="uploadPlaceholder">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-soft-pink-600 hover:text-soft-pink-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-soft-pink-500">
                                <span>Upload gambar</span>
                                <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Produk <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="<?= old('name') ?>"
                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-soft-pink-500 focus:border-soft-pink-500"
                   placeholder="Masukkan nama produk"
                   required>
            <p class="mt-1 text-sm text-gray-500">Nama produk yang akan ditampilkan kepada pelanggan.</p>
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
                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-soft-pink-500 focus:border-soft-pink-500"
                   placeholder="nama-produk"
                   required>
            <p class="mt-1 text-sm text-gray-500">URL-friendly version dari nama produk (otomatis diisi).</p>
        </div>

        <!-- Category -->
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                Kategori <span class="text-red-500">*</span>
            </label>
            <select id="category_id" 
                    name="category_id" 
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-soft-pink-500 focus:border-soft-pink-500"
                    required>
                <option value="">Pilih kategori</option>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->id ?>" <?= old('category_id') == $category->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category->name) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <p class="mt-1 text-sm text-gray-500">Pilih kategori yang sesuai untuk produk ini.</p>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                Deskripsi <span class="text-red-500">*</span>
            </label>
            <textarea id="description" 
                      name="description" 
                      rows="4" 
                      class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-soft-pink-500 focus:border-soft-pink-500"
                      placeholder="Deskripsikan produk Anda dengan detail..."
                      required><?= old('description') ?></textarea>
            <p class="mt-1 text-sm text-gray-500">Jelaskan produk Anda dengan detail untuk menarik pelanggan.</p>
        </div>

        <!-- Price and Stock -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                    Harga <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" 
                           id="price" 
                           name="price" 
                           value="<?= old('price') ?>"
                           min="0"
                           step="1000"
                           class="block w-full pl-12 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-soft-pink-500 focus:border-soft-pink-500"
                           placeholder="0"
                           required>
                </div>
                <p class="mt-1 text-sm text-gray-500">Harga produk dalam Rupiah.</p>
            </div>

            <!-- Stock -->
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                    Stok <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       id="stock" 
                       name="stock" 
                       value="<?= old('stock') ?>"
                       min="0"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-soft-pink-500 focus:border-soft-pink-500"
                       placeholder="0"
                       required>
                <p class="mt-1 text-sm text-gray-500">Jumlah stok yang tersedia.</p>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="<?= url('products') ?>" 
               class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-soft-pink-500 transition-colors duration-200">
                Batal
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-soft-pink-500 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-soft-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-soft-pink-500 transition-colors duration-200">
                Simpan Produk
            </button>
        </div>
    </form>
</div>

<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slug = name.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
        .replace(/\s+/g, '-') // Replace spaces with hyphens
        .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
        .trim('-'); // Remove leading/trailing hyphens
    
    document.getElementById('slug').value = slug;
});

// Image preview functionality
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('uploadPlaceholder').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
});

// Drag and drop functionality
const dropZone = document.querySelector('.border-dashed');

dropZone.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('border-soft-pink-400', 'bg-soft-pink-50');
});

dropZone.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('border-soft-pink-400', 'bg-soft-pink-50');
});

dropZone.addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('border-soft-pink-400', 'bg-soft-pink-50');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        const file = files[0];
        if (file.type.startsWith('image/')) {
            document.getElementById('image').files = files;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
                document.getElementById('uploadPlaceholder').classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
});

// Format price input
document.getElementById('price').addEventListener('input', function() {
    let value = this.value.replace(/[^0-9]/g, '');
    if (value) {
        // Format with thousand separators for display
        this.setAttribute('data-value', value);
    }
});
</script>

<?php
$content = ob_get_clean();
include 'app/views/layouts/app.php';
?>
