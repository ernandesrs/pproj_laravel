<?php

namespace App\Http\Controllers\Member;

use App\Helpers\Message\Message;
use App\Helpers\Thumb;
use App\Http\Controllers\Controller;
use App\Http\Requests\Member\ProfileFormRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view("member.index", [
            "pageTitle" => "Dashboard"
        ]);
    }

    /**
     * @return View
     */
    public function profile(): View
    {
        return view("member.profile", [
            "pageTitle" => "Meu perfil",
            "profile" => auth()->user()
        ]);
    }

    /**
     * @param ProfileFormRequest $request
     * @return JsonResponse
     */
    public function profileUpdate(ProfileFormRequest $request): JsonResponse
    {
        $validated = $request->validated();

        /** @var User */
        $user = auth()->user();

        // PHOTO UPLOAD
        if ($validated["photo"] ?? null) {
            $photo = $validated["photo"];
            $path = $photo->store("avatars", "public");

            if ($user->photo) {
                Thumb::clear($user->photo);
                Storage::delete("public/{$user->photo}");
            }

            $user->photo = $path;
        }

        $user->first_name = $validated["first_name"];
        $user->last_name = $validated["last_name"];
        $user->username = $validated["username"];
        $user->gender = $validated["gender"];

        if (!empty($validated["password"]))
            $user->password = Hash::make($validated["password"]);

        $user->save();

        (new Message())->success("{$user->first_name}, seus dados foram atualizados com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "reload" => true,
        ]);
    }
}
