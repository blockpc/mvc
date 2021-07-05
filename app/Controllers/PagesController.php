<?php

namespace App\Controllers;

use App\Core\Controller;

class PagesController extends Controller
{
    public function home()
    {
        $user = "Juan Carlos";
        $this->render('pages.home', [
            'user' => $user,
        ]);
    }

    public function responsive()
    {
        $this->render('pages.responsive');
    }
}