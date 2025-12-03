<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    /**
     * عرض قائمة جميع الصور
     */
    public function index()
    {
        $photos = Photo::paginate(12);
        return view('photos.photos_index', compact('photos'));
    }

    /**
     * عرض نموذج رفع صورة جديدة
     */
    public function create()
    {
        return view('photos.photos_create');
    }

    /**
     * حفظ الصورة الجديدة
     */
    public function store(Request $request)
    {
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
            $path = $file->storeAs('photos', $filename, 'public');

            Photo::create([
                'album_id' => null,
                'filename' => $filename,
                'path' => $path,
                'description' => $validated['description'] ?? null,
            ]);
        }

        return redirect()->route('photos.index')->with('success', 'تم رفع الصورة بنجاح');
    }

    /**
     * عرض الصورة
     */
    public function show(Photo $photo)
    {
        return view('photos.photos_show', compact('photo'));
    }

    /**
     * عرض نموذج تعديل الصورة
     */
    public function edit(Photo $photo)
    {
        return view('photos.photos_edit', compact('photo'));
    }

    /**
     * تحديث بيانات الصورة
     */
    public function update(Request $request, Photo $photo)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string|max:500',
        ], [
            'image.image' => 'الملف يجب أن يكون صورة',
            'image.mimes' => 'صيغ الصور المسموحة: jpeg, png, jpg, gif',
            'image.max' => 'حجم الصورة لا يجب أن يتجاوز 2MB',
        ]);

        // إذا تم رفع صورة جديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            Storage::disk('public')->delete($photo->path);
            
            // حفظ الصورة الجديدة
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('photos', $filename, 'public');
            
            $validated['filename'] = $filename;
            $validated['path'] = $path;
        }

        $photo->update($validated);

        return redirect()->route('photos.show', $photo)->with('success', 'تم تحديث الصورة بنجاح');
    }

    /**
     * حذف الصورة
     */
    public function destroy(Photo $photo)
    {
        // حذف الملف من التخزين
        Storage::disk('public')->delete($photo->path);

        // حذف السجل من قاعدة البيانات
        $photo->delete();

        return redirect()->route('photos.index')->with('success', 'تم حذف الصورة بنجاح');
    }
}
