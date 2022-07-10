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
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * @return View
     */
    public function index(Request $request): View
    {
        return view("admin.users-list", [
            "pageTitle" => "Listagem de membros",
            "users" => $this->filter($request)
        ]);
    }

    /**
     * @param Request $request
     * @return []
     */
    private function filter(Request $request)
    {
        $users = User::whereNotNull("id");

        if ($request->get("filter")) {
            if ($search = $request->get("search"))
                $users->whereRaw("MATCH(first_name, last_name, name, email) AGAINST('{$search}')");

            if ($status = $request->get("status")) {
                $status = $status == "verified" ? true : ($status == "unverified" ? false : null);
                if ($status === true)
                    $users->whereNotNull("email_verified_at");
                else if ($status === false)
                    $users->whereNull("email_verified_at");
            }
        }

        return $users->get();
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
        $user->level = $validated["level"] !== User::LEVEL_9 ? $validated["level"] : User::LEVEL_1;
        $user->gender = $validated["gender"];
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
        $validator = $this->userValidate($request, $user);

        if ($errors = $validator->errors()->messages()) {
            return response()->json([
                "success" => false,
                "message" => (new Message())->warning("Erro ao validar os dados informados")->float()->render(),
                "errors" => array_map(function ($item) {
                    return $item[0];
                }, $errors)
            ]);
        }

        $validated = $validator->validated();

        // PHOTO UPLOAD
        if ($validated["photo"] ?? null) {
            $photo = $validated["photo"];
            $newPhotoPath = $photo->store("public/avatars");

            // REMOÇÃO DE FOTO ANTIGA
            if ($user->photo)
                Storage::delete($user->photo);

            $user->photo = $newPhotoPath;
        }

        $user->name = $validated["first_name"] . " " . $validated["last_name"];
        $user->first_name = $validated["first_name"];
        $user->last_name = $validated["last_name"];
        $user->gender = $validated["gender"];

        // VALIDA E ATUALIZA NÍVEL APENAS SE
        if ($user->id != auth()->user()->id)
            $user->level = $validated["level"] != User::LEVEL_9 ? $validated["level"] : User::LEVEL_1;

        // ATUALIZAR SENHA SE
        if ($validated["password"] ?? null)
            $user->password = Hash::make($validated["password"]);

        if (!$user->save()) {
            if ($newPhotoPath)
                Storage::delete($newPhotoPath);

            return response()->json([
                "success" => false,
                "message" => (new Message())->warning("Houve um erro ao registrar usuário.")->float()->render()
            ]);
        }

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
        $only = ["first_name", "last_name", "level", "gender", "photo", "password", "password_confirmation"];
        $rules = [
            "first_name" => ["required"],
            "last_name" => ["required"],
            "level" => ["numeric", Rule::in(User::LEVELS)],
            "gender" => ["required", Rule::in(User::GENDERS)],
            "photo" => ["mimes:jpg,png", "max:2048"]
        ];

        if (!$user) {
            $only = array_merge($only, ["email"]);
            $rules += [
                "email" => ["required", "unique:App\Models\User"],
                "password" => ["required", "confirmed", "min:6", "max:18"],
                "password_confirmation" => ["required"],
            ];
        }

        if ($user && !empty($request->get("password"))) {
            $rules += [
                "password" => ["required", "min:6", "max:18", "confirmed"],
            ];
        }

        return Validator::make($request->only($only), $rules);
    }
}
