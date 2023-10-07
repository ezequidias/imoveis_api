<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterRequest extends Request
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
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'c_password' => ['required', 'same:password'],
        ];
    }

    /**
     * @return array
     */
    private function updateRules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email'],
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
