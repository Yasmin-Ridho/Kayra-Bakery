<?php

require_once 'core/Controller.php';
require_once 'app/models/Category.php';
require_once 'core/Request.php';

/**
 * Category Controller
 * 
 * Controller untuk menangani halaman kategori
 * Menggunakan base Controller class untuk helper methods
 */

class CategoryController extends Controller
{
    public function __construct()
    {
        // check if user role is admin
        if (!isLoggedIn()) {
            redirect(url('login'));
            exit;
        } else {
            if (getCurrentUser()['role'] != 'admin') {
                setFlashMessage('error', 'Anda tidak memiliki akses ke halaman ini.');
                redirect(url('login'));
                exit;
            }
        }
    }

    /**
     * Halaman index kategori
     */
    public function index()
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        $categories = Category::all();

        $this->view('apps/categories/index', [
            'categories' => $categories
        ]);
    }

    /**
     * Halaman create kategori
     */
    public function create()
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        $this->view('apps/categories/create');
    }

    /**
     * Halaman store kategori
     */
    public function store()
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        $request = request();

        // Validasi input
        $isValid = $request->validate([
            'name' => 'required|min:3|max:255',
            'slug' => 'required|min:3|max:255|unique:categories,slug'
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.min' => 'Nama kategori minimal 3 karakter.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
            'slug.required' => 'Slug kategori wajib diisi.',
            'slug.min' => 'Slug kategori minimal 3 karakter.',
            'slug.max' => 'Slug kategori maksimal 255 karakter.',
            'slug.unique' => 'Slug kategori sudah digunakan.'
        ]);

        if (!$isValid) {
            redirect(url('categories/create'));
            return;
        }

        // Ambil data yang sudah divalidasi
        $categoryData = $request->only([
            'name', 'slug'
        ]);

        // Set default values
        $categoryData['created_at'] = date('Y-m-d H:i:s');
        $categoryData['updated_at'] = date('Y-m-d H:i:s');

        // Simpan data kategori
        try {
            Category::create($categoryData);
            
            // Clear old input setelah berhasil
            Request::clearOld();
            
            setFlashMessage('success', 'Kategori berhasil ditambahkan!');
            redirect(url('categories'));
        } catch (Exception $e) {
            setFlashMessage('error', 'Gagal menambahkan kategori: ' . $e->getMessage());
            redirect(url('categories/create'));
        }
    }

    /**
     * Halaman show kategori
     */
    public function show($id)
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        $category = Category::find($id);

        if (!$category) {
            setFlashMessage('error', 'Kategori tidak ditemukan.');
            redirect(url('categories'));
            return;
        }

        $this->view('apps/categories/show', [
            'category' => $category
        ]);
    }

    /**
     * Halaman edit kategori
     */
    public function edit($id)
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        $category = Category::find($id);

        if (!$category) {
            setFlashMessage('error', 'Kategori tidak ditemukan.');
            redirect(url('categories'));
            return;
        }

        $this->view('apps/categories/edit', [
            'category' => $category
        ]);
    }

    /**
     * Halaman update kategori
     */
    public function update($id)
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        $request = request();

        // Cari kategori
        $category = Category::find($id);
        if (!$category) {
            setFlashMessage('error', 'Kategori tidak ditemukan.');
            redirect(url('categories'));
            return;
        }

        // Validasi input
        $isValid = $request->validate([
            'name' => 'required|min:3|max:255',
            'slug' => 'required|min:3|max:255'
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.min' => 'Nama kategori minimal 3 karakter.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
            'slug.required' => 'Slug kategori wajib diisi.',
            'slug.min' => 'Slug kategori minimal 3 karakter.',
            'slug.max' => 'Slug kategori maksimal 255 karakter.'
        ]);

        if (!$isValid) {
            redirect(url('categories/' . $id . '/edit'));
            return;
        }

        // Ambil data yang sudah divalidasi
        $categoryData = $request->only([
            'name', 'slug'
        ]);

        // Set default values
        $categoryData['updated_at'] = date('Y-m-d H:i:s');

        // Update data kategori
        try {
            Category::updateById($id, $categoryData);
            
            // Clear old input setelah berhasil
            Request::clearOld();
            
            setFlashMessage('success', 'Kategori berhasil diperbarui!');
            redirect(url('categories'));
        } catch (Exception $e) {
            setFlashMessage('error', 'Gagal memperbarui kategori: ' . $e->getMessage());
            redirect(url('categories/' . $id . '/edit'));
        }
    }

    /**
     * Halaman delete kategori
     */
    public function delete($id)
    {
        // Check authentication
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            redirect(url('login'));
            return;
        }

        $category = Category::find($id);

        if (!$category) {
            setFlashMessage('error', 'Kategori tidak ditemukan.');
            redirect(url('categories'));
            return;
        }

        try {
            Category::deleteById($id);
            setFlashMessage('success', 'Kategori "' . $category->name . '" berhasil dihapus!');
        } catch (Exception $e) {
            setFlashMessage('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }

        redirect(url('categories'));
    }
}

?>