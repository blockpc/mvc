<?php

namespace App\Requests;

use App\Models\Permission;

class PermissionRequest extends BaseRequest
{
    public function validate(int $id = 0)
    {
        if ( !$this->body ) {
            return false;
        }

        $rule_key_unique = 'unique,'.Permission::class.':key';
        $rule_name_unique = 'unique,'.Permission::class.':name';
        if ( $this->request->method == 'put' ) {
            $rule_key_unique = 'unique_ignore,'.Permission::class.':key;id:'.$id;
            $rule_name_unique = 'unique_ignore,'.Permission::class.':name;id:'.$id;
        }

        // set validation rules
        $this->validator->validation_rules([
            'key'      => 'required|alpha_numeric|'.$rule_key_unique,
            'name'      => 'required|alpha_numeric_space|'.$rule_name_unique,
            'group'      => 'required|alpha_numeric',
            'description'      => 'es_string',
        ]);

        // set filter rules
        $this->validator->filter_rules([
            'key'   => 'trim|sanitize_string',
            'name'   => 'trim|sanitize_string',
            'group'   => 'trim|sanitize_string',
            'description'   => 'trim|sanitize_string',
        ]);

        $this->validator->set_field_names([
            'key'      => 'llave',
            'name'      => 'nombre',
            'group'      => 'grupo',
            'description'      => 'descripción',
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