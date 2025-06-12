<?php

require_once 'core/autoload.php';
require_once 'app/models/Product.php';
require_once 'app/models/Category.php';
require_once 'core/Request.php';
require_once 'core/Storage.php';
require_once 'core/Paginator.php';

/**
 * Product Controller
 * 
 * Controller untuk menangani halaman produk
 * Menggunakan base Controller class untuk helper methods
 */

class ProductController extends Controller
{
    public function __construct()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            redirect(url('login'));
            exit;
        }
        // Note: tidak langsung check role admin di sini, 
        // karena user juga boleh akses method tertentu seperti index()
    }

    /**
     * Helper method untuk check apakah user adalah admin
     */
    private function requireAdmin()
    {
        if (getCurrentUser()['role'] != 'admin') {
            setFlashMessage('error', 'Anda tidak memiliki akses ke halaman ini. Hanya admin yang diizinkan.');
            redirect(url('products'));
            exit;
        }
    }

    /**
     * Halaman landing products untuk user
     * Available for: public (all users)
     */
    public function landing()
    {
        // Get all available products (stock > 0)
        $products = Product::where('stock', '>', 0);
        
        // Get categories for filter
        $categories = Category::all();
        
        // Add category name to products
        foreach ($products as $product) {
            $category = $product->category();
            $product->category_name = $category ? $category->name : 'Umum';
        }
        
        // Sort products by created_at descending (newest first)
        usort($products, function($a, $b) {
            return strtotime($b->created_at ?? '2024-01-01') - strtotime($a->created_at ?? '2024-01-01');
        });
        
        $this->view('landings/products', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    /**
     * Halaman index produk
     * Available for: admin, user
     */
    public function index()
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        // Pastikan user adalah admin
        $this->requireAdmin();

        $products = Product::paginate(10);

        $this->view('apps/products/index', [
            'products' => $products
        ]);
    }

    /**
     * Halaman create produk
     */
    public function create()
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        // Pastikan user adalah admin
        $this->requireAdmin();

        // Get categories for dropdown
        $categories = Category::all();

        $this->view('apps/products/create', [
            'categories' => $categories
        ]);
    }

    /**
     * Halaman store produk
     */
    public function store()
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        // Pastikan user adalah admin
        $this->requireAdmin();

        $request = request();

        // Validasi input
        $isValid = $request->validate([
            'name' => 'required|min:3|max:255',
            'slug' => 'required|min:3|max:255|unique:products,slug',
            'description' => 'required|min:10',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'category_id' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max_size:2048'
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.min' => 'Nama produk minimal 3 karakter.',
            'name.max' => 'Nama produk maksimal 255 karakter.',
            'slug.required' => 'Slug produk wajib diisi.',
            'slug.min' => 'Slug produk minimal 3 karakter.',
            'slug.max' => 'Slug produk maksimal 255 karakter.',
            'slug.unique' => 'Slug produk sudah digunakan.',
            'description.required' => 'Deskripsi produk wajib diisi.',
            'description.min' => 'Deskripsi produk minimal 10 karakter.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric' => 'Harga produk harus berupa angka.',
            'price.min' => 'Harga produk tidak boleh negatif.',
            'stock.required' => 'Stok produk wajib diisi.',
            'stock.numeric' => 'Stok produk harus berupa angka.',
            'stock.min' => 'Stok produk tidak boleh negatif.',
            'category_id.required' => 'Kategori produk wajib dipilih.',
            'category_id.numeric' => 'Kategori produk tidak valid.',
            'image.required' => 'Gambar produk wajib diisi.',
            'image.image' => 'Gambar produk harus berupa gambar.',
            'image.mimes' => 'Gambar produk harus berupa file jpeg, png, jpg, gif, atau webp.',
            'image.max_size' => 'Gambar produk maksimal 2MB'
        ]);

        if (!$isValid) {
            redirect(url('products/create'));
            return;
        }

        // Ambil data yang sudah divalidasi (tanpa image)
        $productData = $request->only([
            'name', 'slug', 'description', 'price', 'stock', 'category_id'
        ]);

        // Set default values
        $productData['created_at'] = date('Y-m-d H:i:s');
        $productData['updated_at'] = date('Y-m-d H:i:s');

        // Simpan data produk
        try {
            $product = Product::create($productData);
            
            // Handle image upload jika ada
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = $product->uploadImage($_FILES['image']);
                
                if (!$uploadResult['success']) {
                    setFlashMessage('warning', 'Produk berhasil ditambahkan, tapi gagal mengupload gambar: ' . $uploadResult['message']);
                    redirect(url('products'));
                    return;
                }
            }
            
            // Clear old input setelah berhasil
            Request::clearOld();
            
            setFlashMessage('success', 'Produk berhasil ditambahkan!');
            redirect(url('products'));
        } catch (Exception $e) {
            setFlashMessage('error', 'Gagal menambahkan produk: ' . $e->getMessage());
            redirect(url('products/create'));
        }
    }

    /**
     * Halaman show produk
     * Available for: admin, user
     */
    public function show($id)
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        // Pastikan user adalah admin
        $this->requireAdmin();

        $product = Product::find($id);

        if (!$product) {
            setFlashMessage('error', 'Produk tidak ditemukan.');
            redirect(url('products'));
            return;
        }

        // Load category relationship
        $category = $product->category();

        $this->view('apps/products/show', [
            'product' => $product,
            'category' => $category
        ]);
    }

    /**
     * Halaman edit produk
     */
    public function edit($id)
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        // Pastikan user adalah admin
        $this->requireAdmin();

        $product = Product::find($id);

        if (!$product) {
            setFlashMessage('error', 'Produk tidak ditemukan.');
            redirect(url('products'));
            return;
        }

        // Get categories for dropdown
        $categories = Category::all();

        $this->view('apps/products/edit', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * Halaman update produk
     */
    public function update($id)
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        // Pastikan user adalah admin
        $this->requireAdmin();

        $request = request();

        // Cari produk
        $product = Product::find($id);
        if (!$product) {
            setFlashMessage('error', 'Produk tidak ditemukan.');
            redirect(url('products'));
            return;
        }

        // Validasi input
        $isValid = $request->validate([
            'name' => 'required|min:3|max:255',
            'slug' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'category_id' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max_size:2048'
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.min' => 'Nama produk minimal 3 karakter.',
            'name.max' => 'Nama produk maksimal 255 karakter.',
            'slug.required' => 'Slug produk wajib diisi.',
            'slug.min' => 'Slug produk minimal 3 karakter.',
            'slug.max' => 'Slug produk maksimal 255 karakter.',
            'description.required' => 'Deskripsi produk wajib diisi.',
            'description.min' => 'Deskripsi produk minimal 10 karakter.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric' => 'Harga produk harus berupa angka.',
            'price.min' => 'Harga produk tidak boleh negatif.',
            'stock.required' => 'Stok produk wajib diisi.',
            'stock.numeric' => 'Stok produk harus berupa angka.',
            'stock.min' => 'Stok produk tidak boleh negatif.',
            'category_id.required' => 'Kategori produk wajib dipilih.',
            'category_id.numeric' => 'Kategori produk tidak valid.',
            'image.image' => 'Gambar produk harus berupa gambar.',
            'image.mimes' => 'Gambar produk harus berupa file jpeg, png, jpg, gif, atau webp.',
            'image.max_size' => 'Gambar produk maksimal 2MB'
        ]);

        if (!$isValid) {
            redirect(url('products/' . $id . '/edit'));
            return;
        }

        // Ambil data yang sudah divalidasi (tanpa image)
        $productData = $request->only([
            'name', 'slug', 'description', 'price', 'stock', 'category_id'
        ]);

        // Set default values
        $productData['updated_at'] = date('Y-m-d H:i:s');

        // Update data produk
        try {
            Product::updateById($id, $productData);
            
            // Refresh product object untuk mendapatkan data terbaru
            $product = Product::find($id);
            
            // Handle image upload jika ada
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = $product->uploadImage($_FILES['image']);
                
                if (!$uploadResult['success']) {
                    setFlashMessage('warning', 'Produk berhasil diperbarui, tapi gagal mengupload gambar: ' . $uploadResult['message']);
                    redirect(url('products/' . $id));
                    return;
                }
            }
            
            // Clear old input setelah berhasil
            Request::clearOld();
            
            setFlashMessage('success', 'Produk berhasil diperbarui!');
            redirect(url('products/' . $id));
        } catch (Exception $e) {
            setFlashMessage('error', 'Gagal memperbarui produk: ' . $e->getMessage());
            redirect(url('products/' . $id . '/edit'));
        }
    }

    /**
     * Halaman delete produk
     */
    public function delete($id)
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        // Pastikan user adalah admin
        $this->requireAdmin();

        $product = Product::find($id);

        // ensure no transaction data referenced to this product
        $transactionItems = TransactionItem::where('product_id', $id);
        if (!empty($transactionItems)) {
            setFlashMessage('error', 'Produk tidak dapat dihapus karena masih ada transaksi yang terkait.');
            redirect(url('products'));
            return;
        }

        if (!$product) {
            setFlashMessage('error', 'Produk tidak ditemukan.');
            redirect(url('products'));
            return;
        }

        try {
            // Delete image jika ada
            if ($product->image) {
                $product->deleteImage();
            }
            
            // Delete product
            Product::deleteById($id);
            setFlashMessage('success', 'Produk "' . $product->name . '" berhasil dihapus!');
        } catch (Exception $e) {
            setFlashMessage('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }

        redirect(url('products'));
    }
}

?>
