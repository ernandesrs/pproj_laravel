<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $home = Page::where("id", "=", 11)->first();

        return view("front.home", [
            "pageTitle" => $home->title ?? "Home",
            "pageDescription" => $home->description ?? "",
            "pageFollow" => $home->follow,
            "pageCover" => m_page_cover_thumb($home, [800, 600]),
            "pageUrl" => route("front.home"),
        ]);
    }
}
