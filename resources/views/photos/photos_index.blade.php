@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">📷 إدارة الصور</h1>
            <a href="{{ route('photos.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + رفع صورة جديدة
            </a>
        </div>

        @if ($message = Session::get('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ $message }}
            </div>
        @endif

        @if ($photos->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">لا توجد صور حتى الآن</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($photos as $photo)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <div class="relative pb-full">
                            <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->filename }}" class="w-full h-48 object-cover">
                        </div>
                        <div class="p-4">
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $photo->description ?? 'بدون وصف' }}</p>
                            <div class="flex justify-between items-center gap-2">
                                <a href="{{ route('photos.show', $photo) }}" class="text-blue-500 hover:text-blue-700 text-sm font-semibold">
                                    عرض
                                </a>
                                <a href="{{ route('photos.edit', $photo) }}" class="text-yellow-500 hover:text-yellow-700 text-sm font-semibold">
                                    تعديل
                                </a>
                                <form action="{{ route('photos.destroy', $photo) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold">
                                        حذف
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $photos->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
