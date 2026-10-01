<?php

namespace App\Http\Requests;

use App\Models\TeacherStaff;
use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create', TeacherStaff::class) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'subject'  => 'nullable|string|max:255',
            'photo'    => 'nullable|string|max:1000',
            'nip'      => 'nullable|string|max:255',
            'status'   => 'required|in:aktif,nonaktif',
        ];
    }
}
