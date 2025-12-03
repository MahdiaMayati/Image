<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * عرض الصور في ألبوم معين
     */
    public function index($albumId)
    {
        $album = Album::findOrFail($albumId);
        $photos = $album->photos()->paginate(12);
        return view('photos.index', compact('album', 'photos'));
    }

    /**
     * عرض نموذج رفع صورة جديدة
     */
    public function create($albumId)
    {
        $album = Album::findOrFail($albumId);
        return view('photos.create', compact('album'));
    }

    /**
     * حفظ الصورة الجديدة
     */
    public function store(Request $request, $albumId)
    {
        $album = Album::findOrFail($albumId);

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string|max:500',
        ], [
            'image.required' => 'يجب اختيار صورة',
            'image.image' => 'الملف يجب أن يكون صورة',
            'image.mimes' => 'صيغ الصور المسموحة: jpeg, png, jpg, gif',
            'image.max' => 'حجم الصورة لا يجب أن يتجاوز 2MB',
        ]);

        // حفظ الصورة
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('photos/album_' . $albumId, $filename, 'public');

            Photo::create([
                'album_id' => $albumId,
                'filename' => $filename,
                'path' => $path,
                'description' => $validated['description'] ?? null,
            ]);
        }

        return redirect()->route('photos.index', $albumId)->with('success', 'تم رفع الصورة بنجاح');
    }

    /**
     * عرض الصورة
     */
    public function show(Photo $photo)
    {
        return view('photos.show', compact('photo'));
    }

    /**
     * عرض نموذج تعديل الصورة
     */
    public function edit(Photo $photo)
    {
        return view('photos.edit', compact('photo'));
    }

    /**
     * تحديث بيانات الصورة
     */
    public function update(Request $request, Photo $photo)
    {
        $validated = $request->validate([
            'description' => 'nullable|string|max:500',
        ]);

        $photo->update($validated);

        return redirect()->route('photos.show', $photo)->with('success', 'تم تحديث الصورة بنجاح');
    }

    /**
     * حذف الصورة
     */
    public function destroy(Photo $photo)
    {
        $albumId = $photo->album_id;

        // حذف الملف من التخزين
        Storage::disk('public')->delete($photo->path);

        // حذف السجل من قاعدة البيانات
        $photo->delete();

        return redirect()->route('photos.index', $albumId)->with('success', 'تم حذف الصورة بنجاح');
    }
}
