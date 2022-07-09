<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    //
    public function home()
    {
        return view("member.home", [
            "pageTitle" => "Dashboard"
        ]);
    }

    public function example()
    {
        return view("member.home", ["pageTitle" => "Example"]);
    }

    public function exampleTwo()
    {
        return view("member.home", ["pageTitle" => "Example Two"]);
    }
}
