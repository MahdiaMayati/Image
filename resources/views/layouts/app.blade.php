<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Image Gallery')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            {{-- <a href="{{ route('albums.index') }}" class="text-2xl font-bold text-blue-600"> --}}
                📷 Gallery
            </a>
            <ul class="flex gap-6">
                <li><a href="{{ route('photos.index') }}" class="text-gray-700 hover:text-blue-600 font-semibold">الصور</a></li>
                <li><a href="{{ route('photos.create') }}" class="text-gray-700 hover:text-blue-600 font-semibold">+ صورة جديدة</a></li>
                {{-- <li><a href="{{ route('albums.index') }}" class="text-gray-700 hover:text-blue-600 font-semibold">الألبومات</a></li> --}}
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-6 mt-12">
        <p>&copy; 2025 Image Gallery. جميع الحقوق محفوظة</p>
    </footer>
</body>
</html>
