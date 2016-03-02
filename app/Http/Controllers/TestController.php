<?php



namespace App\Http\Controllers;
use EasyWeChat\Foundation\Application;

class TestController extends Controller
{
    public function menu(Application $app)
    {
        $menu = $app->menu;

        $menus = $menu->all();
        return $menus;
    }




    
}