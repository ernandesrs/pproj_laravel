<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class GRecaptcha
{
    private const GOOGLE_RECAPTCHA_URL_VERIFY = "https://www.google.com/recaptcha/api/siteverify";

    /**
     * Verifica o uso do Google Recapcha e retorna o html com a chave pública
     * @return string
     */
    public static function render(): string
    {
        if (self::active())
            return "<div class='g-recaptcha' data-sitekey='" . env('APP_GOOGLE_RECAPTCHAV2_SITE_KEY') . "'></div>";

        return "";
    }

    /**
     * Verifica o uso do Google Recapcha e retorna o html com script
     * @return string
     */
    public static function script(): string
    {
        if (self::active())
            return "<script src='https://www.google.com/recaptcha/api.js?hl=" . app()->getLocale() . "'></script>";

        return "";
    }

    /**
     * Valida o desafio
     * @param array|string $param
     * @return boolean
     */
    public static function verify($param): bool
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
     * Retorna true ou false se a aplicação está usando Google Recaptcha
     * @return boolean
     */
    public static function active(): bool
    {
        return env("APP_USE_RECAPTCHA");
    }
}
