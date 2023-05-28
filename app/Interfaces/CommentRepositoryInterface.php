<?php
namespace App\Interfaces;

interface CommentRepositoryInterface
{
    /**
     * fungsi untuk menambahkan data komentar
     *
     * @param array $commentDetails
     * @return void
     */
    public function insertComment(array $commentDetails);
}
