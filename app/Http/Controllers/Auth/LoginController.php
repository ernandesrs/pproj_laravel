<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function login(): \Illuminate\Contracts\View\View
    {
        return view("auth.login", ["pageTitle" => "Login"]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->only(["email", "password"]), [
            "email" => ["required", "email"],
            "password" => ["required"]
        ], [
            "email.required" => "Informe um email válido",
            "password.required" => "Informe sua senha"
        ]);

        if ($errors = $validator->errors()->messages()) {
            return response()->json([
                "success" => false,
                "message" => implode(", ", array_map(function ($item) {
                    return $item[0];
                }, $errors))
            ]);
        }

        if (Auth::attempt($validator->validated())) {
            $request->session()->regenerate();
            return response()->json([
                "success" => true,
                "redirect" => route("front.home")
            ]);
        }

        return response()->json([
            "success" => false,
            "message" => "The provided credentials do not match our records."
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route("front.home");
    }
}
