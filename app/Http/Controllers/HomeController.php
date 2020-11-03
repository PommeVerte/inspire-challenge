<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * Class HomeController
 * Handles landing page requests
 *
 * @author  Dylan Millikin <dylan.millikin@gmail.com>
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Home page.
     * @return Application|Factory|View
     */
    public function welcome()
    {
        return view('welcome');
    }
}
