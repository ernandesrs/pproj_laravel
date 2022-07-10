<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Message\Message;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        (new Message())->success("Um novo usuário foi registrado com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "redirecto" => route("admin.users.index")
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
            Storage::unlink($user->photo);

        $user->delete();

        (new Message())->success("O usuário foi excluído com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "reload" => true
        ]);
    }
}
