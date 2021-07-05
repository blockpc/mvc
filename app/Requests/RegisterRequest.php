<?php
namespace App\Requests;

use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;
use App\Models\User;

class RegisterRequest extends BaseRequest
{
    public function validate()
    {
        if ( !$this->body ) {
            return false;
        }

        // set validation rules
        $this->validator->validation_rules([
            'name'      => 'required|alpha_numeric|unique,'.User::class.':name',
            'email'      => 'required|valid_email|unique,'.User::class.':email',
            'password'   => 'required|max_len,20|min_len,6',
            'confirm_password' => 'required|equalsfield,password',
            'firstname'   => 'alpha_numeric_space',
            'lastname'   => 'alpha_numeric_space',
        ]);

        // set filter rules
        $this->validator->filter_rules([
            'name'   => 'trim|sanitize_string',
            'email'      => 'trim|sanitize_email',
            'password'   => 'trim',
            'confirm_password' => 'trim',
            'firstname'   => 'trim|sanitize_string',
            'lastname'   => 'trim|sanitize_string',
        ]);

        $this->validator->set_field_names([
            'name'   => 'usuario',
            'email'      => 'correo',
            'password'   => 'clave',
            'confirm_password' => 'confirma clave',
            'firstname'   => 'nombres',
            'lastname'   => 'apellidos',
        ]);

        $valid_data = $this->validator->run($this->body);

        if ($this->validator->errors()) {
            foreach ( $this->validator->get_errors_array() as $key => $value ) {
                session($key, $value);
            }
            return false;
        } else {
            $valid['user'] = [
                'name'   => $valid_data['name'],
                'email'   => $valid_data['email'],
                'password'   => $valid_data['password'],
                'role_id'   => 3,
            ];
            $valid['profile'] = [
                'firstname'   => $valid_data['firstname'] ?: null,
                'lastname'   => $valid_data['lastname'] ?: null,
            ];
            return $valid;
        }
    }
}