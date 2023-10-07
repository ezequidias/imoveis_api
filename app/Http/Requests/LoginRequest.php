<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LoginRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        // UPDATE
        if (in_array($this->method(), ['POST', 'CREATE'])) {
            $rules = $this->createRules();
        }

        return $rules;
    }

    /**
     * @return array
     */
    private function createRules()
    {
        return [
            'email' => ['required'],
            'password' => ['required'],
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
