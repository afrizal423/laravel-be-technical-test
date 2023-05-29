<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentPostRequest;
use App\Http\Resources\CommentInsertResponse;
use App\Interfaces\NewsRepositoryInterface;
use App\Interfaces\CommentRepositoryInterface;

class CommentsController extends Controller
{
    private CommentRepositoryInterface $commentRepository;

    public function __construct(
        CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function createComment(CommentPostRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        // data diisi dengan id dari user admin yg telah login
        $userId = auth()->user()->id;
        $validatedData['user_id'] = $userId;

        $this->commentRepository->insertComment($validatedData);
        // echo json_encode($validatedData);
        return response()->json(
            (new CommentInsertResponse($validatedData)),
            Response::HTTP_CREATED);
    }
}
