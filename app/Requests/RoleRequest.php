<?php
namespace App\Requests;

use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;
use App\Models\Role;
use App\Models\User;

class RoleRequest extends BaseRequest
{
    public function validate(int $id = 0)
    {
        if ( !$this->body ) {
            return false;
        }

        $rule_key_unique = 'unique,'.Role::class.':key';
        $rule_name_unique = 'unique,'.Role::class.':name';
        if ( $this->request->method == 'put' ) {
            $rule_key_unique = 'unique_ignore,'.Role::class.':key;id:'.$id;
            $rule_name_unique = 'unique_ignore,'.Role::class.':name;id:'.$id;
        }

        // set validation rules
        $this->validator->validation_rules([
            'key'      => 'required|alpha|'.$rule_key_unique,
            'name'      => 'required|alpha_space|'.$rule_name_unique,
            'description'   => 'es_string',
        ]);

        // set filter rules
        $this->validator->filter_rules([
            'key'   => 'trim|sanitize_string',
            'name'      => 'trim|sanitize_string',
            'description'   => 'trim|sanitize_string',
        ]);

        $this->validator->set_field_names([
            'key'   => 'llave',
            'name'      => 'nombre',
            'description'   => 'descripción',
        ]);

        $valid_data = $this->validator->run($this->body);

        if ($this->validator->errors()) {
            foreach ( $this->validator->get_errors_array() as $key => $value ) {
                session($key, $value);
            }
            return false;
        } else {
            return $valid_data;
        }
    }
}