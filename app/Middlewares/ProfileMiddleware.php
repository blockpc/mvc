<?php
namespace App\Middlewares;

use App\Exceptions\ForbiddenException;

class ProfileMiddleware extends BaseMiddleware
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function execute()
    {
        if ( !auth() ) {
            throw new ForbiddenException();
        }
        if ( $this->id !== auth()->id ) {
            throw new ForbiddenException("You can see only your profile");
        }
    }
}