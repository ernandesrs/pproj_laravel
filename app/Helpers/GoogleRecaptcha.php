<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class GoogleRecaptcha
{
    private const GOOGLE_RECAPTCHA_URL_VERIFY = "https://www.google.com/recaptcha/api/siteverify";

    /**
     * Verifica o uso do Google Recapcha e renderiza o html com a chave pública
     * @return string
     */
    public static function gRecaptchaRender(): string
    {
        if (self::gRecaptcha())
            return "<div class='g-recaptcha' data-sitekey='" . env('APP_GOOGLE_RECAPTCHAV2_SITE_KEY') . "'></div>";

        return "";
    }

    /**
     * Valida o desafio
     * @param array|string $param
     * @return boolean
     */
    public static function gRecaptchaVerify($param): bool
    {
        $token = is_array($param) ? $param["g-recaptcha-response"] ?? null : $param;

        if (!$token) return false;

        $response = Http::get(self::GOOGLE_RECAPTCHA_URL_VERIFY, [
            'secret' => env("APP_GOOGLE_RECAPTCHAV2_PRIVATE_KEY"),
            'response' => $token
        ]);

        return ($response ?? false) ? $response["success"] : false;
    }

    /**
     * Retorna true ou false se a aplicação está usando Google recaptcha
     * @return boolean
     */
    public static function gRecaptcha(): bool
    {
        return env("APP_USE_RECAPTCHA");
    }
}
