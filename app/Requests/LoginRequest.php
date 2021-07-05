<?php
namespace App\Requests;

use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;

class LoginRequest extends BaseRequest
{
    public function validate()
    {
        if ( !$this->body ) {
            return false;
        }

        // set validation rules
        $this->validator->validation_rules([
            'email'      => 'required|valid_email',
            'password'   => 'required',
            'rememberme' => 'boolean',
        ]);

        // set filter rules
        $this->validator->filter_rules([
            'password'   => 'trim',
            'email'      => 'trim|sanitize_email',
            'rememberme' => 'boolean',
        ]);

        // set field-rule specific error messages
        // $this->validator->set_fields_error_messages([
        //     'email'      => ['required' => 'Fill the email field please, its required.'],
        //     'password'   => ['required' => 'Please enter a valid credit card.']
        // ]);

        $valid_data = $this->validator->run($this->body);

        if ($this->validator->errors()) {
            foreach ( $this->validator->get_errors_array() as $key => $value ) {
                session($key, $value);
            }
            return false;
        } else {
            $valid_data['rememberme'] = isset($valid_data['rememberme']) ? 1 : 0;
            return $valid_data;
        }
    }
}