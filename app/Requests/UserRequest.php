<?php
namespace App\Requests;

use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;
use App\Models\Role;
use App\Models\User;

class UserRequest extends BaseRequest
{
    public function validate(int $id = 0)
    {
        if ( !$this->body ) {
            return false;
        }

        $rule_mail_unique = 'unique,'.User::class.':email';
        $rule_name_unique = 'unique,'.User::class.':name';
        if ( $this->request->method == 'put' ) {
            $rule_mail_unique = 'unique_ignore,'.User::class.':email;id:'.$id;
            $rule_name_unique = 'unique_ignore,'.User::class.':name;id:'.$id;
        }

        // set validation rules
        $this->validator->validation_rules([
            'name'      => 'required|alpha_numeric|'.$rule_name_unique,
            'email'      => 'required|valid_email|'.$rule_mail_unique,
            'password'   => 'max_len,20|min_len,6',
            'confirm_password'   => 'equalsfield,password|max_len,20|min_len,6',
            'role_id'   => 'required|integer|min_numeric,2|exists,'.Role::class.':id',
            'firstname'   => 'alpha_numeric_space',
            'lastname'   => 'alpha_numeric_space',
        ]);

        // set filter rules
        $this->validator->filter_rules([
            'name'   => 'trim|sanitize_string',
            'email'      => 'trim|sanitize_email',
            'password'   => 'trim',
            'role_id'   => 'trim',
            'firstname'   => 'trim|sanitize_string',
            'lastname'   => 'trim|sanitize_string',
        ]);

        $this->validator->set_field_names([
            'name'   => 'usuario',
            'email'      => 'correo',
            'password'   => 'clave',
            'role_id' => 'cargo',
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
            $password = $valid_data['password'] ?: $this->password();
            $new_user = [
                'name'   => $valid_data['name'],
                'email'   => $valid_data['email'],
                'role_id'   => $valid_data['role_id'],
            ];
            if ( $this->request->method == 'put' ) {
                if ( $valid_data['password'] ) {
                    $new_user['password'] = $valid_data['password'];
                }
            } else {
                $new_user['password'] = $valid_data['password'] ?: $this->password();
            }
            $valid['user'] = $new_user;
            $valid['profile'] = [
                'firstname'   => $valid_data['firstname'] ?: null,
                'lastname'   => $valid_data['lastname'] ?: null,
            ];
            return $valid;
        }
    }

    public function password()
    {
        return password();
    }
}