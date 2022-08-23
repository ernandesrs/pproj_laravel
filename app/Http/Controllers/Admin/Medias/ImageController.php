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
        $images = Image::whereNotNull("id")->orderBy("created_at", "DESC");

        if ($request->isXmlHttpRequest()) {
            $images = $images->paginate(6);

            foreach ($images as $image) {
                $image->thumb = thumb(Storage::path("public/{$image->path}"), 200, 125);
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
     * Store a newly created resource in storage.
     *
     * @param  ImageFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageFormRequest $request)
    {
        $validated = $request->validated();

        $image = new Image();
        $image->name = $validated["name"] ?? $validated["file"]->getClientOriginalName();
        $image->tags = $validated["tags"] ?? null;
        $image->extension = $validated["file"]->getClientOriginalExtension();
        $image->size = $validated["file"]->getSize();
        $image->path = $validated["file"]->store($this->imagesPath, "public");

        $image->save();

        message()->success("Upload de nova imagem efetuada com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "reload" => true,
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
