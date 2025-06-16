<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Kayra Bakery - Toko Roti Terbaik' ?></title>
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
    </style>
    <?= $additional_head ?? '' ?>
</head>
<body class="bg-white">

    <?php include 'app/views/layouts/navbar.php'; ?>

    <!-- Main Content -->
    <main>
        <?= $content ?? '' ?>
    </main>

    <?php include 'app/views/layouts/footer.php'; ?>

    <!-- Global JavaScript -->
    <script>
        // Smooth scrolling untuk semua anchor links
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
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
            
            // Add animation classes
            const style = document.createElement('style');
            style.textContent = `
                @keyframes fade-in-up {
                    from {
                        opacity: 0;
                        transform: translateY(30px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                .animate-fade-in-up {
                    animation: fade-in-up 1s ease-out;
                }
            `;
            document.head.appendChild(style);
        });
    </script>

    <?= $additional_scripts ?? '' ?>
</body>
</html>
