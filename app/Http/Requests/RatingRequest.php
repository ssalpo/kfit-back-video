<?php

namespace App\Http\Requests;

use App\Constants\Rating;
use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => 'required|numeric',
            'type' => 'required|in:' . implode(',', Rating::TYPES),
            'rating' => 'required|numeric|between:1,5'
        ];
    }
}
