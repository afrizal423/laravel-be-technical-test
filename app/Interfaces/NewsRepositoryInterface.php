<?php
namespace App\Interfaces;

interface NewsRepositoryInterface
{
    /**
     * Fungsi untuk mendapatkan semua data berita
     *
     * @return void
     */
    public function getAllNews();
    /**
     * fungsi untuk mendapatkan berita berdasarkan id
     *
     * @param string $newsId
     * @return void
     */
    public function getDetailNewsById(string $newsId);
    /**
     * fungsi untuk mendapatkan berita berdasarkan id
     *
     * @param string $newsId
     * @return void
     */
    public function getNewsById(string $newsId);
    /**
     * fungsi untuk menambahkan data berita
     *
     * @param array $newsDetails
     * @return void
     */
    public function createDataNews(array $newsDetails);
    /**
     * ungsi untuk mengubah data berita
     *
     * @param string $newsId
     * @param array $newsDetails
     * @return void
     */
    public function updateDataNews(string $newsId, array $newsDetails);
    /**
     * fungsi untuk menghapus data berita
     *
     * @param string $newsId
     * @return void
     */
    public function deleteNews(string $newsId);

    /**
     * fungsi untuk menghitung data berita
     *
     * @param string $newsId
     * @return integer
     */
    public function CountDataNews(string $newsId): int;
}
