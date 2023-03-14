<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTicketsRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes',
            'description' => 'sometimes',
            'priority' => 'sometimes',
            'category' => 'sometimes',
            'status' => 'sometimes',
        ];
    }
}
