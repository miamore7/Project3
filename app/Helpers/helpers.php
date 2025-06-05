<?php

if (!function_exists('getYoutubeEmbedUrl')) {
    /**
     * Mendapatkan URL embed YouTube dari URL YouTube biasa.
     *
     * @param string|null $youtubeUrl URL YouTube.
     * @return string|null URL embed atau null jika tidak valid.
     */
    function getYoutubeEmbedUrl(?string $youtubeUrl): ?string
    {
        if (empty($youtubeUrl)) {
            return null;
        }

        $videoId = null;
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtubeUrl, $matches)) {
            $videoId = $matches[1];
        }

        if ($videoId) {
            return 'https://www.youtube.com/embed/' . $videoId;
        }

        return null; // Atau bisa kembalikan URL asli jika ingin ditampilkan sebagai link biasa
    }
}