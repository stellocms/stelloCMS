<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('generate_slug')) {
    /**
     * Generate a URL-friendly slug from a string
     * 
     * @param string $text The input text to convert to slug
     * @param string $separator The separator character to use
     * @return string The generated slug
     */
    function generate_slug($text, $separator = '-')
    {
        // Convert to lowercase
        $text = strtolower($text);

        // Remove special characters and replace spaces with separator
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = trim($text);
        $text = preg_replace('/[\s-]+/', $separator, $text);

        return $text;
    }
}

if (!function_exists('generate_unique_slug')) {
    /**
     * Generate a unique slug based on the title
     * 
     * @param string $title The title to generate slug from
     * @param string $table The table name to check uniqueness
     * @param string $column The column name for slug
     * @param int|null $id The ID of the record (for updates)
     * @return string The unique slug
     */
    function generate_unique_slug($title, $table = 'berita', $column = 'slug', $id = null)
    {
        $originalSlug = generate_slug($title);
        $slug = $originalSlug;
        $counter = 1;
        $separator = '-';

        // Check if slug already exists in the database
        while (true) {
            $query = DB::table($table)->where($column, $slug);
            
            if ($id) {
                $query = $query->where('id', '!=', $id);
            }
            
            if (!$query->exists()) {
                break;
            }
            
            $slug = $originalSlug . $separator . $counter;
            $counter++;
        }

        return $slug;
    }
}

if (!function_exists('get_latest_news_widget')) {
    /**
     * Get the latest news widget content
     *
     * @param int $limit Number of news to show
     * @return string HTML content of the widget
     */
    function get_latest_news_widget($limit = 5)
    {
        if (class_exists(App\Plugins\Berita\Controllers\BeritaController::class)) {
            $controller = new App\Plugins\Berita\Controllers\BeritaController();
            return $controller->getLatestNewsWidget($limit);
        }

        return '<div class="alert alert-info">Plugin Berita tidak aktif</div>';
    }
}

if (!function_exists('get_popular_news_widget')) {
    /**
     * Get the popular news widget content
     *
     * @param int $limit Number of news to show
     * @return string HTML content of the widget
     */
    function get_popular_news_widget($limit = 5)
    {
        if (class_exists('App\Plugins\Berita\Controllers\BeritaController')) {
            $controller = new App\Plugins\Berita\Controllers\BeritaController();
            return $controller->getPopularNewsWidget($limit);
        }

        return '<div class="alert alert-info">Plugin Berita tidak aktif</div>';
    }
}

if (!function_exists('get_latest_news_data')) {
    /**
     * Get the latest news data
     *
     * @param int $limit Number of news to get
     * @return \Illuminate\Support\Collection
     */
    function get_latest_news_data($limit = 5)
    {
        if (class_exists(App\Plugins\Berita\Models\Berita::class)) {
            return App\Plugins\Berita\Models\Berita::where('aktif', true)
                                           ->orderBy('tanggal_publikasi', 'desc')
                                           ->limit($limit)
                                           ->get(['id', 'judul', 'tanggal_publikasi', 'gambar', 'slug']);
        }

        return collect([]);
    }
}

if (!function_exists('get_random_news_widget')) {
    /**
     * Get the random news widget content that has images
     *
     * @param int $limit Number of news to show (default 1)
     * @return string HTML content of the widget
     */
    function get_random_news_widget($limit = 1)
    {
        if (class_exists(App\Plugins\Berita\Controllers\BeritaController::class)) {
            $controller = new App\Plugins\Berita\Controllers\BeritaController();
            return $controller->getRandomNewsWidget($limit);
        }

        return '<div class="alert alert-info">Plugin Berita tidak aktif</div>';
    }
}

if (!function_exists('get_random_news_data')) {
    /**
     * Get the random news data that has images
     *
     * @param int $limit Number of news to get (default 1)
     * @return \Illuminate\Support\Collection
     */
    function get_random_news_data($limit = 1)
    {
        if (class_exists(App\Plugins\Berita\Controllers\BeritaController::class)) {
            $controller = new App\Plugins\Berita\Controllers\BeritaController();
            return $controller->getRandomNewsData($limit);
        }

        return collect([]);
    }
}