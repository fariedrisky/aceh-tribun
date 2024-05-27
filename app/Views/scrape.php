<?php

require_once '../vendor/autoload.php';

function scraping_acehjaya($url)
{
    // init
    $return = [];

    // create HTML DOM
    $dom = \voku\helper\HtmlDomParser::file_get_html($url);

    // Cek apakah konten berhasil diambil
    if ($dom) {
        // Loop melalui setiap elemen <li> dengan class 'ptb15'
        foreach ($dom->find('li.ptb15') as $article) {
            // Ambil judul artikel
            $title = $article->find('h3 a', 0)->plaintext;

            // Ambil URL artikel
            $url = $article->find('h3 a', 0)->href;

            // Ambil deskripsi artikel
            $description = $article->find('h4', 0)->plaintext;

            // Ambil tanggal publikasi
            $date = $article->find('.grey', 0)->plaintext;

            // Tambahkan informasi artikel ke dalam array
            $return[] = array(
                'Title' => $title,
                'URL' => $url,
                'Description' => $description,
                'Date' => $date
            );
        }
    } else {
        // Tampilkan pesan jika konten tidak dapat diambil
        echo "Failed to fetch content from $url";
    }

    return $return;
}

// Panggil fungsi scraping_acehjaya() untuk mendapatkan data
$data = scraping_acehjaya('https://aceh.tribunnews.com/tag/aceh-jaya');

// Tampilkan hasil
foreach ($data as $article) {
    echo '<strong>Title:</strong> ' . $article['Title'] . '<br>';
    echo '<strong>Description:</strong> ' . $article['Description'] . '<br>';
    echo '<strong>Date:</strong> ' . $article['Date'] . '<br>';
    echo '<strong>URL:</strong> <a href="' . $article['URL'] . '">' . $article['URL'] . '</a><br><br>';
}
