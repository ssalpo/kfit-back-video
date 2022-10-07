<?php

namespace App\Http\Requests;

use App\Constants\Workout;
use Illuminate\Foundation\Http\FormRequest;

class WorkoutRequest extends FormRequest
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
            'title' => 'required|min:3|max:255',
            'source_type' => 'required|numeric|in:' . implode(',', Workout::SOURCE_LIST),
            'source_id' => 'required|string',
            'is_public' => 'required|boolean',
        ];
    }
}
