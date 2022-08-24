<?php

namespace LarodsCoreBlocks\AcfExample;

use LarodsCoreApp\Contracts\Blocks;
use LarodsCoreBlocks\BlockTemplateRender;

class AcfExample extends BlockTemplateRender implements Blocks
{
    public $acf;

    public function __construct()
    {
        $this->acf = new AcfExampleFields();

        add_action('wp_enqueue_scripts', [$this, 'slickSlideAssets']);
        add_action('admin_enqueue_scripts', [ $this, 'slickSlideAssets']);
    }

    public function getBlockJsonPath(): string
    {
        return __DIR__;
    }

    public function slickSlideAssets() {
        wp_enqueue_style('slick-carousel-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css', false);
        wp_enqueue_style('slick-carousel-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css', false);
        wp_enqueue_script('slick-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js', ['jquery'], false, true);
    }

    public function registerBlock()
    {
        if (!function_exists('acf_register_block_type')) {
            return null;
        }

        $blockData = null;
        if (file_exists(__DIR__ . '/block.json')) {
            $blockData = json_decode(file_get_contents(__DIR__ . '/block.json'));
        }

        $blockData->render_callback = function ($blockData) {
            echo $this->renderBlock($blockData);
        };

        $blockData->enqueue_style = LRD_CORE_URL . '/blocks/AcfExample/dist/styles/block.css';
        $blockData->enqueue_script = LRD_CORE_URL . '/blocks/AcfExample/dist/scripts/block.min.js';
        $blockData->mode = 'auto';

        acf_register_block_type($blockData);
    }

    public function renderBlock($attributes): string
    {
        //Get the fields created on ACF
        $field = $attributes['data'];
        $attributes['data'] = $this->acf->sanitizeData($field );

        return $this->renderTemplate('main.twig', __DIR__, $attributes);
    }

    public function init()
    {
        $this->initTemplateEngine();
        $this->registerBlock();
    }
}