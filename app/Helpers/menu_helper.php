<?php

if (!function_exists('set_active')) {
    /**
     * Set the active class for the menu item
     *
     * @param string $uri The URI to check against
     * @param string $output The CSS class to output if active
     * @return string
     */
    function set_active($uri, $output = 'active')
    {
        // Dapatkan URI saat ini
        $current_uri = uri_string();

        // Cocokkan URI saat ini dengan URI menu
        if ($current_uri == $uri) {
            return $output;
        }

        return '';
    }
}
