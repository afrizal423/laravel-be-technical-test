<?php
namespace App\Repository;

use App\Models\Comments;
use App\Jobs\UserComments;
use App\Interfaces\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * fungsi untuk menambahkan data komentar
     *
     * @param array $commentDetails
     * @return void
     */
    public function insertComment(array $commentDetails)
    {
        UserComments::dispatch($commentDetails);
    }
}
