<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Kayra Bakery' ?> - Authentication</title>
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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-6">
    <div class="w-full max-w-md">
        <!-- Auth Container -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            
            <!-- Header -->
            <div class="bg-gray-50 px-6 py-6 text-center border-b border-gray-200">
                <h1 class="text-xl font-bold text-gray-800 mb-2">Kayra Bakery & Cake</h1>
                <p class="text-gray-600 font-medium"><?= $subtitle ?? 'Sistem Authentication' ?></p>
            </div>
            
            <!-- Body -->
            <div class="px-6 py-8">
                <?= $content ?? '' ?>
            </div>
            
            <!-- Footer -->
            <?php if (isset($footer)): ?>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 text-center text-gray-600">
                <?= $footer ?>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Bottom Text -->
        <div class="text-center mt-6">
            <p class="text-gray-600 font-medium">
                Selamat datang di Kayra Bakery
            </p>
        </div>
    </div>
</body>
</html>
