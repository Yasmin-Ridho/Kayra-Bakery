<!-- Footer -->
<footer class="bg-gray-800 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="col-span-2">
                <div class="mb-6">
                    <h3 class="text-xl font-bold mb-2">Kayra Bakery & Cake</h3>
                    <p class="text-gray-300">Premium Bakery</p>
                </div>
                <p class="text-gray-300 leading-relaxed mb-6 text-base">
                    Kayra Bakery adalah toko roti premium yang berkomitmen menghadirkan produk berkualitas tinggi dengan cita rasa yang tak terlupakan untuk keluarga Indonesia.
                </p>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-6 text-gray-200">Menu Cepat</h4>
                <ul class="space-y-3">
                    <li><a href="#home" class="text-gray-300 hover:text-soft-pink-300 transition-colors duration-200">Beranda</a></li>
                    <li><a href="#about" class="text-gray-300 hover:text-soft-pink-300 transition-colors duration-200">Tentang Kami</a></li>
                    <li><a href="#products" class="text-gray-300 hover:text-soft-pink-300 transition-colors duration-200">Produk</a></li>
                    <li><a href="#contact" class="text-gray-300 hover:text-soft-pink-300 transition-colors duration-200">Kontak</a></li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-semibold mb-6 text-gray-200">Kontak</h4>
                <ul class="space-y-3 text-gray-300">
                    <li>Jalan Sarijadi, Bandung</li>
                    <li>+62 812-3456-7890</li>
                    <li>info@kayrabakeryncake.com</li>
                    <li>07:00 - 21:00</li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-700 mt-12 pt-8 text-center">
            <p class="text-gray-400">
                © 2024 Kayra Bakery. Dibuat dengan cinta untuk keluarga Indonesia.
            </p>
        </div>
    </div>
</footer>

<script>
// Smooth scrolling untuk footer links
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('footer a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
