<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Seo;
use App\Helpers\Thumb;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $page = Page::findBySlug("inicio", config("app.locale"));

        return view($page->content->view_path ?? "front.index", [
            "seo" => Seo::set(
                $page->title,
                $page->description,
                route("front.index"),
                Thumb::thumb($page->cover, "cover.normal"),
                $page->follow
            ),
        ]);
    }

    /**
     * @param string $slug
     * @return View|RedirectResponse
     */
    public function dinamicPage(string $slug)
    {
        $page = Page::findBySlug($slug, config("app.locale"));

        if (!$page) {
            message()->danger("Não existe uma página para este endereço: <strong>{$slug}</strong>", "Página não encontrada")->flash();
            return redirect()->route("front.index");
        }

        $slugs = $page->slugs();

        if (in_array($slugs->slug($page->lang), ["inicio", "home"]))
            return redirect()->route("front.index");

        if ($page->content_type == Page::CONTENT_TYPE_VIEW) {
            $content = $page->content;
            $view = $content->view_path;
        } else
            $view = "front.dinamic-page";

        return view($view, [
            "seo" => Seo::set(
                $page->title,
                $page->description,
                route("front.dinamicPage", ["slug" => $slugs->slug($page->lang)]),
                Thumb::thumb($page->cover, "cover.normal"),
                $page->follow
            ),
            "page" => $page
        ]);
    }
}
