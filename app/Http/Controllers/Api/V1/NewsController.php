<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\NewsHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewsPostRequest;
use App\Http\Resources\NewsCollection;
use App\Http\Resources\NewsInsertUpdateResponse;
use App\Http\Resources\NewsResources;
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
        return response()->json(new NewsCollection($this->NewsRepository->getAllNews()),
                            Response::HTTP_OK);
    }

    public function getDataById(Request $request): JsonResponse
    {
        $orderId = $request->route('id');

        return response()->json(new NewsResources($this->NewsRepository->getDetailNewsById($orderId))
            , Response::HTTP_OK);
    }

    public function insertDataNews(NewsPostRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $path = $request->file('image_banner')->store('image', 'public');
        $validatedData['image_banner'] = Storage::url($path);

        // data diisi dengan id dari user admin yg telah login
        $userId = auth()->user()->id;

        $validatedData['user_id'] = $userId;
        $news = $this->NewsRepository->createDataNews($validatedData);

        event(new NewsHistory($news['user_id'], "Created data", $news['id']));
        return response()->json(
            (new NewsInsertUpdateResponse($news))->action('insert'),
            Response::HTTP_CREATED);
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

        // data diisi dengan id dari user admin yg telah login
        $userId = auth()->user()->id;

        $validatedData['user_id'] = $userId;
        $news = $this->NewsRepository->updateDataNews($idNews, $validatedData);

        event(new NewsHistory($news['user_id'], "Update data", $news['id']));

        return response()->json(
            (new NewsInsertUpdateResponse($news))->action('update'),
            Response::HTTP_ACCEPTED);
    }

    public function deleteDataNews(Request $request): JsonResponse
    {
        $idNews = $request->route('id');
        // data diisi dengan id dari user admin yg telah login
        $userId = auth()->user()->id;

        if ($this->NewsRepository->CountDataNews($idNews) == 1) {
            // jika terdapat data
            // hapus image terlebih dahulu
            $oldData = $this->NewsRepository->getNewsById($idNews);
            $pathBannerOld = public_path().str_replace(URL::to('/'), "", $oldData['image_banner']);
            if(file_exists($pathBannerOld))
            {
                // hapus file lama distorage
                unlink($pathBannerOld);
            }

            $this->NewsRepository->deleteNews($idNews);

            event(new NewsHistory($userId, "Delete data", $idNews));

            return response()->json("sukses menghapus data", Response::HTTP_NO_CONTENT);
        } else {
            // jika tidak ada data
            return response()->json("tidak ada data", Response::HTTP_NOT_FOUND);
        }
    }
}
