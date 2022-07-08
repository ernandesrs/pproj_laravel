<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function register(): \Illuminate\Contracts\View\View
    {
        return view("auth.register", ["pageTitle" => "Registro"]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->only(["first_name", "last_name", "email", "password", "password_confirmation"]), [
            "first_name" => ["required"],
            "last_name" => ["required"],
            "email" => ["required", "unique:App\Models\User"],
            "password" => ["required", "confirmed"],
            "password_confirmation" => ["required"],
        ]);

        if ($errors = $validator->errors()->messages()) {
            return response()->json([
                "success" => false,
                "message" => implode(", ", array_map(function ($item) {
                    return $item[0];
                }, $errors))
            ]);
        }

        $validated = (object) $validator->validated();

        $user = new User();
        $user->name = $validated->first_name . " " . $validated->last_name;
        $user->first_name = $validated->first_name;
        $user->last_name = $validated->last_name;
        $user->email = $validated->email;
        $user->password = Hash::make($validated->password);

        if (!$user->save()) {
            return response()->json([
                "success" => false,
                "message" => "Houve um erro ao criar sua conta"
            ]);
        }

        // SEND VERIFICATION E-MAIL
        event(new Registered($user));

        session()->flash("flash_message", [
            "type" => "success",
            "message" => "Conta registrada com sucesso!",
        ]);
        return response()->json([
            "success" => true,
            "redirect" => route("auth.login")
        ]);
    }
}
