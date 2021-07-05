<?php

namespace App\Requests;

use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;

class BaseRequest
{
    protected Validator $validator;
    protected Request $request;
    protected $body;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->validator = new Validator();
        $this->body = $this->request->body();
    }

    protected function errors()
    {
        return $this->validator->get_errors_array();
    }
}