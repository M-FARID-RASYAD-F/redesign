<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $news = $this->route('news');
        return $this->user()?->can('update', $news) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'            => 'required|string|max:255',
            'category_id'      => 'required|exists:news_categories,id',
            'content'          => 'required|string',
            'thumbnail'        => 'nullable|string|max:1000',
            'thumbnail_file'   => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'remove_thumbnail' => 'nullable|boolean',
            'published_at'     => 'nullable|date',
        ];
    }
}
