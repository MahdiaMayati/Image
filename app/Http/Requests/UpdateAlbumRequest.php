<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlbumRequest extends FormRequest
{
    /**
     * تحديد ما إذا كان المستخدم مفوضاً لهذا الطلب
     */
    // public function authorize(): bool
    // {
    //     return auth()->user() !== null;
    // }

    /**
     * الحصول على قواعد التحقق من البيانات
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:albums,title,'.$this->album->id,
            'description' => 'nullable|string|max:1000',
        ];
    }

    /**
     * الرسائل المخصصة للأخطاء
     */
    public function messages(): array
    {
        return [
            'title.required' => 'عنوان الألبوم مطلوب',
            'title.string' => 'عنوان الألبوم يجب أن يكون نصاً',
            'title.max' => 'عنوان الألبوم لا يجب أن يتجاوز 255 حرف',
            'title.unique' => 'هذا العنوان موجود بالفعل',
            'description.string' => 'الوصف يجب أن يكون نصاً',
            'description.max' => 'الوصف لا يجب أن يتجاوز 1000 حرف',
        ];
    }
}
