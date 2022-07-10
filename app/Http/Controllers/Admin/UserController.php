<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Message\Message;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view("admin.users-list", [
            "pageTitle" => "Listagem de membros",
            "users" => User::all()
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view("admin.users-novo", [
            "pageTitle" => "Novo usuário"
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = $this->userValidate($request);

        if ($errors = $validator->errors()->messages()) {
            return response()->json([
                "success" => false,
                "message" => (new Message())->warning("Erro ao validar os dados informados")->float()->render(),
                "errors" => array_map(function ($item) {
                    return $item[0];
                }, $errors)
            ]);
        }

        $user = new User();

        $validated = $validator->validated();

        // PHOTO UPLOAD
        if ($validated["photo"] ?? null) {
            $photo = $validated["photo"];
            $path = $photo->store("public/avatars");

            $user->photo = $path;
        }

        $user->name = $validated["first_name"] . " " . $validated["last_name"];
        $user->first_name = $validated["first_name"];
        $user->last_name = $validated["last_name"];
        $user->email = $validated["email"];
        $user->level = $validated["level"] !== 9 ? $validated["level"] : 1;
        $user->password = Hash::make($validated["password"]);

        if (!$user->save()) {
            if ($path)
                Storage::delete($path);

            return response()->json([
                "success" => false,
                "message" => (new Message())->warning("Houve um erro ao registrar usuário.")->float()->render()
            ]);
        }

        // SEND VERIFICATION E-MAIL
        event(new Registered($user));

        (new Message())->success("Um novo usuário foi registrado com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "redirect" => route("admin.users.index")
        ]);
    }

    /**
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view("admin.users-edit", [
            "pageTitle" => "Editar usuário",
            "user" => $user
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(Request $request, User $user): JsonResponse
    {
        (new Message())->success("O usuário foi atualizado com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "reload" => true
        ]);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        if ($user->id === auth()->user()->id) {
            return response()->json([
                "success" => false,
                "message" => (new Message())->warning("Você não pode excluir sua própria conta!")->fixed()->render()
            ]);
        }

        if ($user->photo)
            Storage::delete($user->photo);

        $user->delete();

        (new Message())->success("O usuário foi excluído com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "reload" => true
        ]);
    }

    /**
     * @param Request $request
     * @param User|null $user if this is a update
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function userValidate(Request $request, ?User $user = null): \Illuminate\Contracts\Validation\Validator
    {
        $only = ["first_name", "last_name", "photo", "password", "password_confirmation"];
        $rules = [
            "first_name" => ["required"],
            "last_name" => ["required"],
            "photo" => ["mimes:jpg,png", "max:2048"]
        ];

        if (!$user) {
            $only = array_merge($only, ["email", "level"]);
            $rules += [
                "email" => ["required", "unique:App\Models\User"],
                "level" => ["numeric"],
                "password" => ["required", "confirmed", "min:6", "max:18"],
                "password_confirmation" => ["required"],
            ];
        }

        if ($user && !empty($data["password"])) {
            $rules += [
                "password" => ["required", "min:6", "max:18", "confirmed"],
            ];
        }

        return Validator::make($request->only($only), $rules);
    }
}
