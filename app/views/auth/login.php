<?php

$title = 'Login';
$subtitle = 'Masuk ke Akun Anda';

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

<!-- Login Form -->
<form method="POST" action="<?= getBaseUrl() ?>/login" class="space-y-6">
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
    
    <!-- Password Field -->
    <div>
        <label for="password" class="block font-semibold text-gray-700 mb-3">
            Password
        </label>
        <div class="relative">
            <input type="password" 
                   id="password" 
                   name="password" 
                   required 
                   placeholder="Masukkan password Anda"
                   class="w-full px-4 py-3 pr-12 border border-gray-200 rounded-lg focus:ring-2 focus:ring-soft-pink-300 focus:border-soft-pink-400 transition-all duration-200 placeholder-gray-400 text-gray-700">
            <button type="button" 
                    id="togglePassword"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <!-- Icon mata tertutup (default) -->
                <svg id="eyeOff" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                </svg>
                <!-- Icon mata terbuka (hidden) -->
                <svg id="eyeOn" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Remember Me & Forgot Password -->
    <div class="flex items-center justify-between pt-2">
        <label class="flex items-center">
            <input type="checkbox" 
                   name="remember" 
                   class="w-4 h-4 text-gray-600 border-gray-300 rounded focus:ring-gray-300 focus:ring-2">
            <span class="ml-3 text-gray-600 font-medium">Ingat saya</span>
        </label>
        <a href="<?= $baseUrl ?>/forgot-password" class="text-soft-pink-500 hover:text-soft-pink-600 font-medium transition-colors duration-200">
            Lupa password?
        </a>
    </div>
    
    <!-- Submit Button -->
    <button type="submit" 
            class="w-full bg-gradient-to-r from-soft-pink-300 to-pink-400 text-white font-semibold py-3 px-6 rounded-lg hover:from-soft-pink-400 hover:to-pink-500 focus:ring-2 focus:ring-soft-pink-300 focus:ring-offset-2 transform transition-all duration-200 hover:scale-[1.01] shadow-lg mt-8">
        Masuk ke Akun
    </button>
</form>

<script>
// Toggle password visibility
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordField = document.getElementById('password');
    const eyeOff = document.getElementById('eyeOff');
    const eyeOn = document.getElementById('eyeOn');
    
    if (passwordField.type === 'password') {
        // Show password
        passwordField.type = 'text';
        eyeOff.classList.add('hidden');
        eyeOn.classList.remove('hidden');
    } else {
        // Hide password
        passwordField.type = 'password';
        eyeOff.classList.remove('hidden');
        eyeOn.classList.add('hidden');
    }
});
</script>

<?php
$content = ob_get_clean();

$footer = '
    <div class="space-y-3">
        <p>Belum punya akun? <a href="'.getBaseUrl().'/register" class="text-soft-pink-500 hover:text-soft-pink-600 font-semibold transition-colors duration-200">Daftar di sini</a></p>
        <p><a href="'.getBaseUrl().'/" class="text-gray-500 hover:text-gray-700 font-medium transition-colors duration-200">Kembali ke Beranda</a></p>
    </div>
';

require_once 'app/views/layouts/auth.php';
?>
