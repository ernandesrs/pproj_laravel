<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Thumb;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserFormRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * @return View
     */
    public function index(Request $request): View
    {
        return view("admin.users.index", [
            "title" => "Usuários",
            "users" => $this->filter($request)
        ]);
    }

    /**
     * @param Request $request
     * @return []
     */
    private function filter(Request $request)
    {
        $filtered = [
            "filter" => filter_var($request->get("filter"), FILTER_VALIDATE_BOOLEAN),
            "search" => filter_var($request->get("search")),
            "status" => filter_var($request->get("status")),
            "level" => filter_var($request->get("level"), FILTER_VALIDATE_INT),
        ];

        /** @var User $users */
        $users = User::whereNotNull("id")->orderBy("level", "DESC")->orderBy("created_at", "DESC");

        if ($filtered["filter"]) {
            if ($filtered["search"])
                $users->whereRaw("MATCH(first_name, last_name, name, email) AGAINST('{$filtered["search"]}')");

            if ($filtered["status"] && in_array($filtered["status"], ["verified", "unverified"])) {
                $status = $filtered["status"] == "verified" ? true : false;
                if ($status === true)
                    $users->whereNotNull("email_verified_at");
                else if ($status === false)
                    $users->whereNull("email_verified_at");
            }

            if ($filtered["level"]) {
                if (in_array($filtered["level"], User::LEVELS))
                    $users->where("level", $filtered["level"]);
            }
        }

        return $users->paginate(12)->withQueryString();
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view("admin.users.new", [
            "title" => "Novo usuário"
        ]);
    }

    /**
     * @param UserFormRequest $request
     * @return JsonResponse
     */
    public function store(UserFormRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = new User();

        // PHOTO UPLOAD
        if ($validated["photo"] ?? null) {
            $photo = $validated["photo"];
            $path = $photo->store("avatars", "public");
            $user->photo = $path;
        }

        $user->name = $validated["first_name"] . " " . $validated["last_name"];
        $user->first_name = $validated["first_name"];
        $user->last_name = $validated["last_name"];
        $user->username = $validated["username"];
        $user->gender = $validated["gender"];
        $user->level = User::LEVEL_1;
        $user->email = $validated["email"];
        $user->password = Hash::make($validated["password"]);

        if (!$user->save()) {
            if ($user->photo)
                Storage::delete("public/{$user->photo}");

            return response()->json([
                "success" => false,
                "message" => message()->warning("Houve um erro ao registrar usuário.")->float()->render()
            ]);
        }

        // SEND VERIFICATION E-MAIL
        event(new Registered($user));

        message()->success("Um novo usuário foi registrado! Uma mensagem de verificação foi enviada para o e-mail informado.")->float()->flash();
        return response()->json([
            "success" => true,
            "redirect" => route("admin.users.edit", ["user" => $user->id])
        ]);
    }

    /**
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view("admin.users.edit", [
            "title" => "Editar usuário",
            "user" => $user
        ]);
    }

    /**
     * @param UserFormRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserFormRequest $request, User $user): JsonResponse
    {
        $validated = $request->validated();

        // PHOTO UPLOAD
        if ($validated["photo"] ?? null) {
            $photo = $validated["photo"];
            $path = $photo->store("avatars", "public");

            // REMOÇÃO DE FOTO ANTIGA
            if ($user->photo) {
                Thumb::clear($user->photo);
                Storage::delete("public/{$user->photo}");
            }

            $user->photo = $path;
        }

        $user->name = $validated["first_name"] . " " . $validated["last_name"];
        $user->first_name = $validated["first_name"];
        $user->last_name = $validated["last_name"];
        $user->username = $validated["username"];
        $user->gender = $validated["gender"];

        // ATUALIZAR SENHA SE
        if ($validated["password"] ?? null)
            $user->password = Hash::make($validated["password"]);

        if (!$user->save()) {
            if ($user->photo)
                Storage::delete("public/{$user->photo}");

            return response()->json([
                "success" => false,
                "message" => message()->warning("Houve um erro ao registrar usuário.")->float()->render()
            ]);
        }

        message()->success("Os dados do usuário foram atualizados com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "reload" => true
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function photoRemove(Request $request, User $user): JsonResponse
    {
        if ($user->photo) {
            Thumb::clear($user->photo);
            Storage::delete("public/{$user->photo}");
        }

        $user->photo = null;
        $user->save();

        message()->success("A foto do usuário foi removida com sucesso.")->float()->flash();
        return response()->json([
            "success" => true,
            "reload" => true,
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
                "message" => message()->warning("Você não pode excluir sua própria conta!")->fixed()->render()
            ]);
        }

        if ($user->photo) {
            Thumb::clear($user->photo);
            Storage::delete("public/{$user->photo}");
        }

        $user->delete();

        message()->success("O usuário foi excluído com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "redirect" => route("admin.users.index")
        ]);
    }
}
