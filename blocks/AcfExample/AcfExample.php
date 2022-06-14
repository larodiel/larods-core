<?php

namespace LarodsCoreBlocks\AcfExample;

use LarodsCoreApp\Contracts\Blocks;
use LarodsCoreBlocks\BlockTemplateRender;

class AcfExample extends BlockTemplateRender implements Blocks
{
    public function getBlockJsonPath(): string
    {
        return __DIR__;
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

        acf_register_block_type($blockData);
    }

    public function renderBlock($attributes): string
    {
        $field = $attributes['data'];

        if ($field['b_ythv_thumbnail']) {
            $field['b_ythv_thumbnail'] = wp_get_attachment_image($field['b_ythv_thumbnail']);
        }

        $attributes['data'] = $field;

        return $this->renderTemplate('main.twig', __DIR__, $attributes);
    }

    public function init()
    {
        $this->initTemplateEngine();
        $this->registerBlock();
    }
}
