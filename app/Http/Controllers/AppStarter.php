<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AppStarter extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        $this->mkMasterAdmin();

        return "<br>* started *<br>";
    }

    /**
     * @return void
     */
    private function mkMasterAdmin()
    {
        $adm = new User();

        if (User::where("email", "admin@admin.com")->count()) {
            echo "master admin exists<br>";
        } else {
            $adm->first_name = "Master";
            $adm->last_name = "Admin";
            $adm->name = $adm->first_name . " " . $adm->last_name;
            $adm->username = $adm->first_name;
            $adm->level = 9;
            $adm->gender = User::GENDER_MALE;
            $adm->email = "admin@admin.com";
            $adm->password = Hash::make("admin");
            $adm->email_verified_at  = date("Y-m-d H:i:s");

            $adm->save();

            echo "master admin created<br>";
        }
    }
}
