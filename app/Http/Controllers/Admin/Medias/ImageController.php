<?php

namespace App\Http\Controllers\Admin\Medias;

use App\Helpers\Thumb;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImageFormRequest;
use App\Models\Medias\Image;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Caminho da imagem a partir de storage/app/public/
     *
     * @var string
     */
    private $imagesPath = "medias/images";

    /**
     * @param Request $request
     * @return JsonResponse|View
     */
    public function index(Request $request)
    {
        $images = $this->filter($request);

        if ($request->isXmlHttpRequest()) {
            $images = $images->paginate(6);

            foreach ($images as $image) {
                $image->thumb = Thumb::thumb($image->path, "cover.small");
                $image->url = Storage::url($image->path);
            }

            return response()->json([
                "success" => true,
                "images" => $images,
                "pagination" => $images->links()->render()
            ]);
        }

        return view("admin.medias.images-index", [
            "title" => "Imagens",
            "images" => $images->paginate(12)->withQueryString()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function filter(Request $request): \Illuminate\Database\Eloquent\Builder
    {
        $validated = [
            "filter" => filter_var($request->get("filter", false), FILTER_VALIDATE_BOOL),
            "search" => filter_var($request->get("search", ""), FILTER_DEFAULT)
        ];

        $images = Image::whereNotNull("id")->orderBy("created_at", "DESC");

        if ($validated["filter"]) {
            if ($validated["search"]) {
                $images->whereRaw("MATCH(name,tags) AGAINST('{$validated["search"]}')");
            }
        }

        return $images;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ImageFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageFormRequest $request)
    {
        $redirect = filter_input(INPUT_GET, "redirect", FILTER_VALIDATE_BOOL) ?? true;
        $validated = $request->validated();

        $image = new Image();
        $image->name = $validated["name"] ?? $validated["file"]->getClientOriginalName();
        $image->tags = $validated["tags"] ?? null;
        $image->extension = $validated["file"]->getClientOriginalExtension();
        $image->size = $validated["file"]->getSize();
        $image->path = $validated["file"]->store($this->imagesPath, "public");

        $image->save();

        $message = message()->success("<small>Upload de nova imagem efetuada com sucesso!</small>");
        if (!$redirect) {
            $image->thumb = Thumb::thumb($image->path, "cover.small");
            $image->url = Storage::url($image->path);

            return response()->json([
                "success" => true,
                "message" => $message->time(12)->fixed()->render(),
                "image" => $image
            ]);
        }

        $message->float()->flash();
        return response()->json([
            "success" => true,
            "redirect" => route("admin.medias.images.index"),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Image $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        return response()->json([
            "success" => true,
            "image" => [
                "name" => $image->name,
                "tags" => $image->tags
            ],
            "action" => route("admin.medias.images.update", ["image" => $image->id])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ImageFormRequest  $request
     * @param  Image $image
     * @return \Illuminate\Http\Response
     */
    public function update(ImageFormRequest $request, Image $image)
    {
        $validated = $request->validated();

        $image->name = $validated["name"];
        $image->tags = $validated["tags"];
        $image->save();

        message()->success("Informações da imagem foram atualziadas com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "reload" => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Image $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        Thumb::clear($image->path);
        Storage::delete("public/{$image->path}");

        $image->delete();

        message()->success("A imagem foi excluida com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "reload" => true,
        ]);
    }
}
