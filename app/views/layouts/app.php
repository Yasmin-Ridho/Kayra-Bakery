<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> - Kayra Bakery & Cake</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'soft-pink': {
                            50: '#fef7f7',
                            100: '#fdeaea',
                            200: '#fbd5d5',
                            300: '#f8b4b4',
                            400: '#f48888',
                            500: '#ec5a5a',
                            600: '#d73737',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #f8b4b4;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #f48888;
        }
        
        /* Sidebar transition */
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
        
        /* Mobile sidebar overlay */
        .sidebar-overlay {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }
    </style>
    <?= $additional_head ?? '' ?>
</head>
<body class="bg-gray-50 font-sans">
    
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 z-40 lg:hidden hidden sidebar-overlay"></div>
    
    <!-- Sidebar -->
    <?php include 'app/views/layouts/sidebar.php'; ?>
    
    <!-- Main Content Area -->
    <div class="lg:ml-64">
        <!-- Topbar -->
        <?php include 'app/views/layouts/topbar.php'; ?>
        
        <!-- Page Content -->
        <main class="p-4 lg:p-6">
            <!-- Alert Messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <?= $_SESSION['success'] ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <?= $_SESSION['error'] ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['info'])): ?>
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <?= $_SESSION['info'] ?>
                    <?php unset($_SESSION['info']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['warning'])): ?>
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <?= $_SESSION['warning'] ?>
                    <?php unset($_SESSION['warning']); ?>
                </div>
            <?php endif; ?>
            
            <!-- Page Content -->
            <?= $content ?? '' ?>
        </main>
    </div>

    <!-- JavaScript -->
    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
        
        // Close sidebar when clicking overlay
        document.getElementById('sidebar-overlay').addEventListener('click', function() {
            toggleSidebar();
        });
        
        // Close sidebar on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                if (!sidebar.classList.contains('-translate-x-full')) {
                    toggleSidebar();
                }
            }
        });
        
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            // Selector yang lebih spesifik untuk alert messages saja
            const alerts = document.querySelectorAll('[role="alert"], .alert, .bg-green-50:has(svg), .bg-red-50:has(svg), .bg-blue-50:has(svg), .bg-yellow-50:has(svg)');
            
            // Lebih spesifik lagi: hanya elemen yang memiliki class alert dan kombinasi warna background + border
            const specificAlerts = document.querySelectorAll(
                '.bg-green-50.border-green-200, .bg-red-50.border-red-200, .bg-blue-50.border-blue-200, .bg-yellow-50.border-yellow-200'
            );
            
            // Gabungkan kedua hasil
            const allAlerts = [...alerts, ...specificAlerts];
            
            // Pastikan tidak ada duplikasi
            const uniqueAlerts = [...new Set(allAlerts)];
            
            uniqueAlerts.forEach(function(alert) {
                // Hanya hapus jika ini benar-benar alert message (memiliki text dan bukan tombol)
                if (alert && !alert.closest('button') && !alert.closest('a') && !alert.closest('form')) {
                    setTimeout(function() {
                        if (alert.parentNode) { // Pastikan elemen masih ada
                            alert.style.transition = 'opacity 0.5s ease-out';
                            alert.style.opacity = '0';
                            setTimeout(function() {
                                if (alert.parentNode) {
                                    alert.remove();
                                }
                            }, 500);
                        }
                    }, 5000);
                }
            });
        });
    </script>

    <?= $additional_scripts ?? '' ?>
</body>
</html>
