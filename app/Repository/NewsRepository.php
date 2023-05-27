<?php
namespace App\Repository;

use App\Interfaces\NewsRepositoryInterface;
use App\Models\News;

class NewsRepository implements NewsRepositoryInterface
{
    /**
     * Fungsi untuk mendapatkan semua data berita
     *
     * @return void
     */
    public function getAllNews()
    {
        return News::paginate(5);
    }

    /**
     * fungsi untuk mendapatkan berita berdasarkan id
     *
     * @param string $newsId
     * @return void
     */
    public function getNewsById(string $newsId)
    {
        return News::findOrFail($newsId);
    }

    /**
     * fungsi untuk menambahkan data berita
     *
     * @param array $newsDetails
     * @return void
     */
    public function createDataNews(array $newsDetails)
    {
        return News::create($newsDetails);
    }

    /**
     * fungsi untuk mengubah data berita
     *
     * @param string $newsId
     * @param array $newsDetails
     * @return void
     */
    public function updateDataNews(string $newsId, array $newsDetails)
    {
        News::whereId($newsId)->update($newsDetails);
        return News::findOrFail($newsId);
    }

    /**
     * fungsi untuk menghapus data berita
     *
     * @param string $newsId
     * @return void
     */
    public function deleteNews(string $newsId)
    {
        News::destroy($newsId);
    }

    /**
     * fungsi untuk menghitung data berita
     *
     * @param string $newsId
     * @return integer
     */
    public function CountDataNews(string $newsId): int
    {
        return News::whereId($newsId)->count();
    }
}
