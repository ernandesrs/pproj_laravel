<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\GRecaptcha;
use App\Helpers\Message\Message;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        $validator = Validator::make($request->only([
            "first_name",
            "last_name",
            "username",
            "gender",
            "email",
            "g-recaptcha-response",
            "password",
            "password_confirmation"
        ]), [
            "first_name" => ["required", "max:25"],
            "last_name" => ["required", "max:75"],
            "gender" => ["required", Rule::in(User::GENDERS)],
            "username" => ["required", "unique:App\Models\User,username", "max:25"],
            "email" => ["required", "unique:App\Models\User"],
            "password" => ["required", "confirmed"],
            "password_confirmation" => ["required"],
            "g-recaptcha-response" => [GRecaptcha::active() ? "required" : "nullable"]
        ]);

        if ($errors = $validator->errors()->messages()) {
            return response()->json([
                "success" => false,
                "message" => (new Message())->warning("Erro ao validar os dados informados")->render(),
                "errors" => array_map(function ($item) {
                    return $item[0];
                }, $errors)
            ]);
        }

        $validated = $validator->validated();

        // RECAPTCHA
        if (GRecaptcha::active()) {

            if (!GRecaptcha::verify($validated)) {
                return response()->json([
                    "success" => false,
                    "errors" => ["g-recaptcha-response" => "Falha no desafio"],
                    "message" => message()->warning("Falha ao validar desafio do recaptcha")->render()
                ]);
            }

            unset($validated["g-recaptcha-response"]);
        }

        $validated = (object) $validated;

        $user = new User();
        $user->name = $validated->first_name . " " . $validated->last_name;
        $user->first_name = $validated->first_name;
        $user->last_name = $validated->last_name;
        $user->username = $validated->username;
        $user->gender = $validated->gender;
        $user->email = $validated->email;
        $user->password = Hash::make($validated->password);

        if (!$user->save()) {
            return response()->json([
                "success" => false,
                "message" => (new Message())->warning("Houve um erro ao criar sua conta")->render()
            ]);
        }

        // SEND VERIFICATION E-MAIL
        event(new Registered($user));

        // AUTOLOGIN
        Auth::loginUsingId($user->id);

        return response()->json([
            "success" => true,
            "redirect" => route("verification.notice")
        ]);
    }
}
