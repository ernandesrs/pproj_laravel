<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Thumb;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageFormRequest;
use App\Models\Page;
use App\Models\Slug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    /** @var int */
    private $limit = 12;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view("admin.pages.index", [
            "title" => "Páginas",
            "pages" => $this->filter($request)
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
        ];

        /** @var Page $pages */
        $pages = Page::whereNotNull("id")->orderBy("created_at", "DESC");

        if ($filtered["filter"]) {
            if ($filtered["search"])
                $pages->whereRaw("MATCH(title,description) AGAINST('{$filtered["search"]}')");

            if ($filtered["status"] && in_array($filtered["status"], Page::STATUS))
                $pages->where("status", $filtered["status"]);
        }

        return $pages->paginate($this->limit)->withQueryString();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.pages.edit", [
            "title" => "Nova página"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PageFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageFormRequest $request)
    {
        // DADOS VALIDADOS
        $validated = $request->validated();

        // DADOS DO SLUG
        $slug = new Slug();
        $slug = $slug->set($validated["title"], $validated["lang"]);
        if (!$slug->save()) {
            return response()->json([
                "success" => false,
                "message" => message()->warning("Erro ao criar slug para o título informado.")->float()->render(),
                "errors" => ["title" => "Tente outro título"]
            ]);
        }

        // DADOS DA PÁGINA
        $page = new Page();
        $page->slug_id = $slug->id;
        $page->author_id = $request->user()->id;
        $page->title = $validated["title"];
        $page->description = $validated["description"];
        $page->lang = $validated["lang"];
        $page->content_type = $validated["content_type"];
        $page->status = $validated["status"];

        if ($page->content_type == Page::CONTENT_TYPE_VIEW)
            $page->content = json_encode([
                "view_path" => $validated["view_path"]
            ]);
        else
            $page->content = $validated["content"];

        if ($page->status == Page::STATUS_SCHEDULED)
            $page->scheduled_to = date("Y-m-d H:i:s", strtotime($validated["scheduled_to"]));
        elseif ($page->status == Page::STATUS_PUBLISHED)
            $page->published_at = date("Y-m-d H:i:s");

        // UPLOAD DE CAPA
        if ($cover = $validated["cover"] ?? null)
            $page->cover = $cover->store("pages/covers", "public");

        if (!$page->save()) {
            $slug->delete();
            Storage::delete("public/{$page->cover}");

            return response()->json([
                "success" => false,
                "message" => message()->warning("Erro ao criar a página. Um log foi registrado.")->float()->render(),
            ]);
        }

        message()->success("Nova página cadastrada com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "redirect" => route("admin.pages.edit", ["page" => $page->id])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view("admin.pages.edit", [
            "title" => "Editar página",
            "page" => $page
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PageFormRequest  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(PageFormRequest $request, Page $page)
    {
        // DADOS VALIDADOS
        $validated = $request->validated();

        // DADOS DA PÁGINA
        $page->title = $validated["title"];
        $page->description = $validated["description"];
        $page->lang = $validated["lang"];
        $page->follow = $validated["follow"] ?? null ? true : false;

        if ($page->protection != Page::PROTECTION_SYSTEM) {
            $page->content_type = $validated["content_type"];
            $page->content = $page->getContent($validated);
            $page->status = $validated["status"];

            if ($page->status == Page::STATUS_SCHEDULED) {
                if ($page->getOriginal("status") != Page::STATUS_SCHEDULED)
                    $page->scheduled_to = date("Y-m-d H:i:s", strtotime($validated["scheduled_to"]));

                $page->published_at = null;
            } else if ($page->status == Page::STATUS_PUBLISHED) {
                if ($page->getOriginal("status") != Page::STATUS_PUBLISHED)
                    $page->published_at = date("Y-m-d H:i:s");
                $page->scheduled_to = null;
            } else {
                $page->published_at = null;
                $page->scheduled_to = null;
            }

            /** @var Slug $slugs */
            $slugs = $page->slugs()->first();
            $slugs->set($validated["title"], $page->lang);
            $slugs->save();
        } else {
            if ($page->content_type == Page::CONTENT_TYPE_TEXT)
                $page->content = $page->getContent([
                    "content_type" => $page->content_type,
                    "content" => $validated["content"],
                ]);
        }

        // UPLOAD DE CAPA
        if ($cover = $validated["cover"] ?? null) {
            if ($page->cover) {
                Thumb::clear($page->cover);
                Storage::delete("public/{$page->cover}");
            }

            $page->cover = $cover->store("pages/covers", "public");
        }

        if (!$page->save()) {
            Storage::delete("public/{$page->cover}");
            return response()->json([
                "success" => false,
                "message" => message()->warning("Erro ao validar dados, verifique e tente de novo.")->float()->render()
            ]);
        }

        message()->success("A página foi atualizada com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "redirect" => route("admin.pages.edit", ["page" => $page->id])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        if ($page->protection == Page::PROTECTION_SYSTEM) {
            return response()->json([
                "success" => false,
                "message" => message()->warning("Página protegida do sistema não pode ser excluída!")->fixed()->render()
            ]);
            return;
        }

        $slugs = $page->slugs();

        if ($page->cover) {
            Thumb::clear($page->cover);
            Storage::delete("public/{$page->cover}");
        }

        $page->delete();

        if ($slugs && !$slugs->hasPages())
            $slugs->delete();

        message()->success("A página foi excluída com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "redirect" => route("admin.pages.index")
        ]);
    }
}
