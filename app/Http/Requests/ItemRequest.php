<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules()
{
    return [
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'condition' => 'required|string',
        'description' => 'nullable|string',
        'photo' => 'nullable|image|max:2048',
        'status' => 'nullable|in:pending,verified,ready,distributed', 
    ];
}
}
