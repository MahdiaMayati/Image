@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">رفع صورة جديدة</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-8">
            @csrf

            <div class="mb-6">
                <label for="image" class="block text-gray-700 font-bold mb-2">الصورة *</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 transition cursor-pointer" id="dropZone">
                    <input
                        type="file"
                        name="image"
                        id="image"
                        class="hidden"
                        accept="image/*"
                    >
                    <div id="dropText">
                        <p class="text-gray-600 mb-2">اسحب الصورة هنا أو</p>
                        <p class="text-blue-500 font-semibold">اختر من جهازك</p>
                        <p class="text-gray-500 text-sm mt-2">الصيغ المسموحة: JPEG, PNG, JPG, GIF</p>
                        <p class="text-gray-500 text-sm">الحد الأقصى: 2MB</p>
                    </div>
                    <img id="preview" style="display:none; max-width: 300px; max-height: 300px; margin-top: 1rem;" alt="معاينة">
                </div>
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-gray-700 font-bold mb-2">الوصف</label>
                <textarea
                    name="description"
                    id="description"
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="أدخل وصف الصورة (اختياري)"
                >{{ old('description') }}</textarea>
            </div>

            <div class="flex gap-4">
                <button
                    type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded"
                >
                    رفع الصورة
                </button>
                <a
                    href="{{ route('photos.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded"
                >
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const dropZone = document.getElementById('dropZone');
    const input = document.getElementById('image');
    const preview = document.getElementById('preview');
    const dropText = document.getElementById('dropText');

    dropZone.addEventListener('click', () => input.click());

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.style.borderColor = '#3b82f6';
        dropZone.style.backgroundColor = '#f0f9ff';
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.style.borderColor = '#d1d5db';
        dropZone.style.backgroundColor = 'white';
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.style.borderColor = '#d1d5db';
        dropZone.style.backgroundColor = 'white';
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            input.files = files;
            showPreview(files[0]);
        }
    });

    input.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            showPreview(e.target.files[0]);
        }
    });

    function showPreview(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            dropText.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
</script>
@endsection
