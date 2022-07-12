<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.pages.pages-list", [
            "pageTitle" => "Listando páginas",
            "pages" => Page::whereNotNull("id")->paginate(12)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.pages.pages-new", [
            "pageTitle" => "Nova página"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = (new Page())->set(
            $request->only([
                "title",
                "description",
                "cover",
                "lang",
                "content_type",
                "content",
                "status",
                "published_at",
                "scheduled_to"
            ]),
            $request->user()
        );

        if ($errors = $page->errors) {
            return response()->json([
                "success" => false,
                "message" => message()->warning("Erro ao validar os dados da página.")->float()->render(),
                "errors" => $errors
            ]);
        }

        if (!$page->save()) {
            return response()->json([
                "success" => false,
                "message" => message()->warning("Erro ao salvar os dados da página.")->float()->render()
            ]);
        }

        message()->success("Nova página cadastrada com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "redirect" => route("admin.pages.index")
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view("admin.pages.pages-new", [
            "pageTitle" => "Editar página",
            "page" => $page
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        //
    }
}
