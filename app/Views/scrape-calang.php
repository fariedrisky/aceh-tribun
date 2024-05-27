<?php

require_once '../vendor/autoload.php';

function scraping_calang($url)
{
    // init
    $return = [];

    // create HTML DOM
    $dom = \voku\helper\HtmlDomParser::file_get_html($url);

    // Cek apakah konten berhasil diambil
    if ($dom) {
        // Loop melalui setiap elemen <li> dengan class 'ptb15'
        foreach ($dom->find('li.ptb15') as $article) {
            // Ambil URL artikel
            $url = $article->find('a', 0)->href;

            // Ambil judul artikel (jika ada)
            $title = '';
            if ($article->find('h3 a', 0)) {
                $title = $article->find('h3 a', 0)->plaintext;
            }

            // Ambil deskripsi artikel (jika ada)
            $description = '';
            if ($article->find('h4', 0)) {
                $description = $article->find('h4', 0)->plaintext;
            }

            // Ambil tanggal publikasi (jika ada)
            $date = '';
            if ($article->find('.grey', 0)) {
                $date = $article->find('.grey', 0)->plaintext;
            }

            // Ambil URL gambar (jika ada)
            $img_url = '';
            if ($article->find('img', 0)) {
                $img_url = $article->find('img', 0)->src;
            }

            // Tambahkan informasi artikel ke dalam array
            $return[] = array(
                'URL' => $url,
                'Title' => $title,
                'Description' => $description,
                'Date' => $date,
                'ImageURL' => $img_url
            );
        }
    } else {
        // Tampilkan pesan jika konten tidak dapat diambil
        echo "Failed to fetch content from $url";
    }

    return $return;
}

// Panggil fungsi scraping_calang() untuk mendapatkan data
$data = scraping_calang('https://aceh.tribunnews.com/tag/calang');

// Tampilkan hasil
foreach ($data as $article) {
    echo '<div class="ptb15">';
    echo '<a href="' . $article['URL'] . '">';
    echo '<img src="' . $article['ImageURL'] . '" height="90" class="shou2" width="120" alt="Image">';
    echo '</a>';
    echo '<h4>' . $article['Description'] . '</h4>';
    echo '</div>';
}
