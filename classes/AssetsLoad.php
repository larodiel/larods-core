<?php

namespace LarodsCoreApp;

class AssetsLoad
{
    public function loadPublicAssets()
    {
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_style('larods-style', LRD_CORE_URL . '/dist/public/styles/main.css', false, LRD_CORE_VERSION);
            wp_enqueue_script('larods-script', LRD_CORE_URL . '/dist/public/scripts/larods-core.min.js', ['jquery'], LRD_CORE_VERSION);
        });
    }
}
