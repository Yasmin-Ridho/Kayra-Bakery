<?php
// Helper function untuk mendapatkan base URL
function getBaseUrl() {
    $script_name = $_SERVER['SCRIPT_NAME'];
    $base_path = dirname($script_name);
    return $base_path === '/' ? '' : $base_path;
}
$baseUrl = getBaseUrl();

$title = 'Lupa Password';
$subtitle = 'Reset Password Anda';

ob_start();
?>

<!-- Alert Messages -->
<?php if (isset($_SESSION['error'])): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
        <?= $_SESSION['error'] ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
        <?= $_SESSION['success'] ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<!-- Info Text -->
<div class="text-center mb-6">
    <p class="text-gray-600 leading-relaxed">
        Masukkan email Anda dan kami akan mengirimkan link untuk reset password ke email tersebut.
    </p>
</div>

<!-- Forgot Password Form -->
<form method="POST" action="/forgot-password" class="space-y-6">
    <!-- Email Field -->
    <div>
        <label for="email" class="block font-semibold text-gray-700 mb-3">
            Email Address
        </label>
        <input type="email" 
               id="email" 
               name="email" 
               required 
               placeholder="Masukkan email Anda"
               value="<?= $_POST['email'] ?? '' ?>"
               class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-soft-pink-300 focus:border-soft-pink-400 transition-all duration-200 placeholder-gray-400 text-gray-700">
    </div>
    
    <!-- Submit Button -->
    <button type="submit" 
            class="w-full bg-gradient-to-r from-soft-pink-300 to-pink-400 text-white font-semibold py-3 px-6 rounded-lg hover:from-soft-pink-400 hover:to-pink-500 focus:ring-2 focus:ring-soft-pink-300 focus:ring-offset-2 transform transition-all duration-200 hover:scale-[1.01] shadow-lg mt-8">
        Kirim Link Reset Password
    </button>
</form>

<!-- Additional Info -->
<div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
    <h4 class="font-semibold text-gray-700 mb-2">💡 Catatan:</h4>
    <ul class="text-sm text-gray-600 space-y-1">
        <li>• Link reset password akan dikirim ke email yang terdaftar</li>
        <li>• Periksa folder spam jika tidak menerima email</li>
        <li>• Link akan kadaluarsa dalam 24 jam</li>
    </ul>
</div>

<?php
$content = ob_get_clean();

$footer = '
    <div class="space-y-3">
        <p>Ingat password Anda? <a href="'.$baseUrl.'/login" class="text-soft-pink-500 hover:text-soft-pink-600 font-semibold transition-colors duration-200">Login di sini</a></p>
        <p>Belum punya akun? <a href="'.$baseUrl.'/register" class="text-soft-pink-500 hover:text-soft-pink-600 font-semibold transition-colors duration-200">Daftar di sini</a></p>
        <p><a href="'.$baseUrl.'/" class="text-gray-500 hover:text-gray-700 font-medium transition-colors duration-200">Kembali ke Beranda</a></p>
    </div>
';

require_once 'app/views/layouts/auth.php';
?> 