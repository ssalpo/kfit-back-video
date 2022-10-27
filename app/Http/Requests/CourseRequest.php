<?php

namespace App\Http\Requests;

use App\Constants\Course;
use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'name' => 'required|min:3|max:255',
            'cover' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'muscles' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'recommendations' => 'nullable|array',
            'active' => 'required|boolean',
            'is_public' => 'nullable|boolean',
            'course_type' => 'nullable|numeric|in:' . implode(',', Course::COURSE_TYPES),
            'trainer_id' => 'nullable|numeric',
            'direction' => 'nullable|string|max:255',
            'active_area' => 'nullable|string|max:255',
            'inventory' => 'nullable|string|max:255',
            'pulse_zone' => 'nullable|string|max:255',
        ];
    }
}
