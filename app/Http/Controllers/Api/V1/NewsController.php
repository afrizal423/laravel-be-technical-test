<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewsPostRequest;
use Illuminate\Support\Facades\Storage;
use App\Interfaces\NewsRepositoryInterface;

class NewsController extends Controller
{
    private NewsRepositoryInterface $NewsRepository;

    public function __construct(NewsRepositoryInterface $NewsRepository)
    {
        $this->NewsRepository = $NewsRepository;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->NewsRepository->getAllNews());
    }

    public function getDataById(Request $request): JsonResponse
    {
        $orderId = $request->route('id');

        return response()->json([
            'data' => $this->NewsRepository->getNewsById($orderId)
        ], Response::HTTP_OK);
    }

    public function insertDataNews(NewsPostRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $path = $request->file('image_banner')->store('image', 'public');
        $validatedData['image_banner'] = Storage::url($path);
        // echo json_encode($validatedData);

        // ubah ini hari senin
        // untuk data diisi dengan id dari user admin yg telah login
        $validatedData['user_id'] = User::where("is_admin", true)->inRandomOrder()->first()->id;


        return response()->json($this->NewsRepository->createDataNews($validatedData), Response::HTTP_CREATED);
    }

    public function updateDataNews(NewsPostRequest $request): JsonResponse
    {
        $idNews = $request->route('id');
        $validatedData = $request->validated();
        $oldData = $this->NewsRepository->getNewsById($idNews);
        if ($request->file('image_banner')) {
            // jika ada foto banner
            $pathBannerOld = public_path().str_replace(URL::to('/'), "", $oldData['image_banner']);
            if(file_exists($pathBannerOld))
            {
                // hapus file lama distorage
                unlink($pathBannerOld);
            }
            // upload new file banner
            $path = $request->file('image_banner')->store('image', 'public');
            $validatedData['image_banner'] = Storage::url($path);
        } else {
            // jika tidak ada foto
            $validatedData['image_banner'] = $oldData['image_banner'];
        }
        // echo json_encode($validatedData);
        return response()->json($this->NewsRepository->updateDataNews($idNews, $validatedData), Response::HTTP_ACCEPTED);
    }

    public function deleteDataNews(Request $request): JsonResponse
    {
        $idNews = $request->route('id');
        $this->NewsRepository->deleteNews($idNews);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
