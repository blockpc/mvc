<?php
namespace App\Core;

use GUMP;
use Ausi\SlugGenerator\SlugGenerator;

class Validator extends GUMP
{
    protected $generator;

    public function __construct(string $lang = "es")
    {
        parent::__construct($lang);
        $this->generator = new SlugGenerator;

        parent::set_error_message('unique', 'El {field} ya existe');
        parent::set_error_message('unique_ignore', 'El {field} ya existe');
        parent::set_error_message('exists', 'El {field} no existe');
        parent::set_error_message('between_len', 'El valor no permitido');
    }

    protected function validate_unique($field, array $input, array $params = [], $value)
    {
        [$class, $column] = explode(":", $params[0]);
        $exist = $class::where($column, $value)->pluck($column)->first();
        return !$exist ? true : false;
    }

    protected function validate_unique_ignore($field, array $input, array $params = [], $value)
    {
        [$class, $column] = explode(":", $params[0]);
        [$columnKey, $valueKey] = explode(":", $params[1]);
        $exist = $class::where($column, $value)->where($columnKey, '!=', $valueKey)->pluck($column)->first();
        return !$exist ? true : false;
    }

    protected function validate_exists($field, array $input, array $params = [], $value)
    {
        [$class, $column] = explode(":", $params[0]);
        $exist = $class::where($column, $value)->pluck($column)->first();
        return $exist == $value;
    }

    protected function validate_base64($field, array $input, array $params = [], $value)
    {
        return true;
    }

    protected function validate_es_string($field, array $input, array $params = [], $value)
    {
        return is_string(trim($value));
    }
}