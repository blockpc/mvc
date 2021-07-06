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
        session('success', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quasi blanditiis, accusantium eius molestias nisi debitis ut inventore quam placeat, quaerat vero vitae ratione saepe minus ea? In consequatur sunt hic?');
        $this->render('pages.responsive');
    }
}