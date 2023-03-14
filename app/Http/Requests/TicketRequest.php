<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed $title
 * @property mixed $description
 * @property mixed $priority
 * @property mixed $category
 */
class TicketRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required',
            'priority' => 'sometimes',
            'category' => 'sometimes',
            ];
    }
}
