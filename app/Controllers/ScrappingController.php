<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ScrapingController extends Controller
{
    public function index()
    {
        $url = 'https://aceh.tribunnews.com/tag/aceh-jaya';
        $scrapedData = $this->scrapeAcehTribunNews($url);

        // Mengirimkan data ke view
        return view('index', ['scrapedData' => $scrapedData]);
    }


    private function scrapeAcehTribunNews($url)
    {
        // Buat instance dari Guzzle Client
        $client = new Client();

        try {
            // Kirim permintaan GET ke URL
            $response = $client->request('GET', $url);

            // Ambil konten dari respons
            $html = (string) $response->getBody();

            // Buat instance dari Symfony DomCrawler
            $crawler = new Crawler($html);

            // Pilih semua elemen dengan class "lsi" dan ambil isinya
            $content = $crawler->filter('.lsi')->each(function (Crawler $node, $i) {
                return $node->text();
            });

            // Kembalikan konten yang telah diambil
            return $content;
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return 'Error: ' . $e->getMessage();
        }
    }
}
