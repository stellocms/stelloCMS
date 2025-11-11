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