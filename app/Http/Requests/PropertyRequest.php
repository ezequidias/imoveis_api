<?php

namespace App\Http\Requests;

use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use App\Http\Requests\Request;
use Illuminate\Validation\Rules\Enum;

class PropertyRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        // CREATE
        if (in_array($this->method(), ['POST', 'CREATE'])) {
            $rules = $this->createRules();
        }

        // UPDATE
        if (in_array($this->method(), ['PUT', 'PATCH', 'UPDATE'])) {
            $rules = $this->updateRules();
        }

        return $rules;
    }

    /**
     * @return array
     */
    private function createRules()
    {
        return [
            'type' => ['required', new Enum(PropertyType::class)],
            'address' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'status' => ['required', new Enum(PropertyStatus::class)],
        ];
    }

    /**
     * @return array
     */
    private function updateRules()
    {
        return [
            'type' => ['required', new Enum(PropertyType::class)],
            'address' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'status' => ['required', new Enum(PropertyStatus::class)],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        $messages = [];

        return $messages;
    }
}
