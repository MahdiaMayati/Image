@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('photos.index') }}" class="text-blue-500 hover:text-blue-700 mb-4">← العودة للصور</a>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="flex justify-between items-start p-6 border-b">
                <h1 class="text-2xl font-bold text-gray-800">عرض الصورة</h1>
                <div class="flex gap-2">
                    <a
                        href="{{ route('photos.edit', $photo) }}"
                        class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded"
                    >
                        تعديل
                    </a>
                    <form action="{{ route('photos.destroy', $photo) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف الصورة؟');">
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                        >
                            حذف
                        </button>
                    </form>
                </div>
            </div>

            <div class="p-6">
                <div class="mb-6">
                    <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->filename }}" class="w-full h-auto rounded-lg">
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-gray-600">اسم الملف:</p>
                        <p class="text-gray-800 font-semibold">{{ $photo->filename }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">تاريخ الرفع:</p>
                        <p class="text-gray-800 font-semibold">{{ $photo->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>

                <div>
                    <p class="text-gray-600">الوصف:</p>
                    <p class="text-gray-800 leading-relaxed">{{ $photo->description ?? 'لا يوجد وصف' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
