<?php

require_once 'core/Controller.php';
require_once 'app/models/User.php';
require_once 'app/models/Transaction.php';

class UserController extends Controller
{
    /**
     * Constructor
     */
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
     * Halaman index user
     */
    public function index()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            return redirect(getBaseUrl() . '/login');
        }

        // Get all users
        $users = User::all();

        // Sort users by created_at descending (newest first)
        usort($users, function($a, $b) {
            return strtotime($b->created_at ?? '1970-01-01') - strtotime($a->created_at ?? '1970-01-01');
        });

        // Create a simple object for frontend compatibility
        $usersObject = new stdClass();
        $usersObject->items = $users;
        $usersObject->totalCount = count($users);

        $this->view('apps/users/index', [
            'users' => $usersObject
        ]);
    }

    /**
     * Halaman create user
     */
    public function create()
    {
        // Check if user is logged in and admin
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            return redirect(getBaseUrl() . '/login');
        }

        if (getCurrentUser()['role'] != 'admin') {
            setFlashMessage('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect(url('users'));
            return;
        }

        $this->view('apps/users/create');
    }

    /**
     * Store new user
     */
    public function store()
    {
        $request = request();

        // Validate input
        $isValid = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,user',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ]);

        if (!$isValid) {
            setFlashMessage('error', 'Validasi gagal. Silakan periksa input Anda.');
            redirect(url('users/create'));
            return;
        }

        // Create user data
        $userData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'password' => $request->input('password')
        ];

        try {
            // Create user using User model method that handles password hashing
            $user = User::createUser($userData);
            
            setFlashMessage('success', 'User berhasil ditambahkan.');
            redirect(url('users'));
        } catch (Exception $e) {
            setFlashMessage('error', 'Gagal menambahkan user: ' . $e->getMessage());
            redirect(url('users/create'));
        }
    }

    /**
     * Halaman show user
     */
    public function show($id)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            return redirect(getBaseUrl() . '/login');
        }

        $user = User::find($id);
        
        if (!$user) {
            setFlashMessage('error', 'User tidak ditemukan.');
            redirect(url('users'));
            return;
        }

        $this->view('apps/users/show', [
            'user' => $user
        ]);     
    }

    /**
     * Halaman edit user
     */
    public function edit($id)
    {
        // Check if user is logged in and admin
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            return redirect(getBaseUrl() . '/login');
        }

        if (getCurrentUser()['role'] != 'admin') {
            setFlashMessage('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect(url('users'));
            return;
        }

        $user = User::find($id);
        
        if (!$user) {
            setFlashMessage('error', 'User tidak ditemukan.');
            redirect(url('users'));
            return;
        }

        $this->view('apps/users/edit', [
            'user' => $user
        ]);
    }

    /**
     * Update user
     */
    public function update($id)
    {
        $request = request();

        $user = User::find($id);
        if (!$user) {
            setFlashMessage('error', 'User tidak ditemukan.');
            redirect(url('users'));
            return;
        }

        // Prepare validation rules
        $validationRules = [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,user',
        ];

        // Add password validation only if password is provided
        if ($request->input('password')) {
            $validationRules['password'] = 'required|min:6';
            $validationRules['password_confirmation'] = 'required|same:password';
        }

        $isValid = $request->validate($validationRules);

        if (!$isValid) {
            setFlashMessage('error', 'Validasi gagal. Silakan periksa input Anda.');
            redirect(url('users/' . $id . '/edit'));
            return;
        }

        // Prepare user data
        $userData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role')
        ];

        // Add password to update data if provided
        if ($request->input('password')) {
            $userData['password'] = password_hash($request->input('password'), PASSWORD_DEFAULT);
        }

        try {
            // Update user using updateById method from original controller
            $user->updateById($id, $userData);

            setFlashMessage('success', 'User berhasil diperbarui.');
            redirect(url('users/' . $id));
        } catch (Exception $e) {
            setFlashMessage('error', 'Gagal memperbarui user: ' . $e->getMessage());
            redirect(url('users/' . $id . '/edit'));
        }
    }

    /**
     * Delete user
     */
    public function destroy($id)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            setFlashMessage('error', 'Anda harus login terlebih dahulu.');
            return redirect(getBaseUrl() . '/login');
        }
        
        // Check if user is admin
        if (getCurrentUser()['role'] != 'admin') {
            setFlashMessage('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect(url('users'));
            return;
        }

        // check if user has no transaction
        $transactions = Transaction::where('user_id', $id);
        if (count($transactions) > 0) {
            setFlashMessage('error', 'User tidak dapat dihapus karena memiliki transaksi.');
            redirect(url('users'));
            return;
        }

        $user = User::find($id);
        if (!$user) {
            setFlashMessage('error', 'User tidak ditemukan.');
            redirect(url('users'));
            return;
        }

        // Prevent deleting current user
        if ($user->id == getCurrentUser()['id']) {
            setFlashMessage('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            redirect(url('users'));
            return;
        }

        try {
            // Delete user using the deleteById method from original controller
            User::deleteById($id);
            setFlashMessage('success', 'User berhasil dihapus.');
        } catch (Exception $e) {
            setFlashMessage('error', 'Gagal menghapus user: ' . $e->getMessage());
        }

        redirect(url('users'));
    }
}