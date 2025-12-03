<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{

    public function index()
    {
        $photos = Photo::paginate(12);
        return view('photos.photos_index', compact('photos'));
    }


    public function create()
    {
        return view('photos.photos_create');
    }


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


        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('photos', $filename, 'public');

            Photo::create([

                'filename' => $filename,
                'path' => $path,
                'description' => $validated['description'] ?? null,
            ]);
        }

        return redirect()->route('photos.index')->with('success', 'تم رفع الصورة بنجاح');
    }


    public function show(Photo $photo)
    {
        return view('photos.photos_show', compact('photo'));
    }


    public function edit(Photo $photo)
    {
        return view('photos.photos_edit', compact('photo'));
    }


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


        if ($request->hasFile('image')) {

            Storage::disk('public')->delete($photo->path);


            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('photos', $filename, 'public');

            $validated['filename'] = $filename;
            $validated['path'] = $path;
        }

        $photo->update($validated);

        return redirect()->route('photos.show', $photo)->with('success', 'تم تحديث الصورة بنجاح');
    }


    public function destroy(Photo $photo)
    {
       
        Storage::disk('public')->delete($photo->path);

        $photo->delete();

        return redirect()->route('photos.index')->with('success', 'تم حذف الصورة بنجاح');
    }
}
