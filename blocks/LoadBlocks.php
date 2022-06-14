<?php

namespace LarodsCoreBlocks;

class LoadBlocks
{
    private $blocks = ['
        AcfExample\AcfExample
    '];

    public function __construct()
    {
        $this->addCategory();

        add_action('init', function () {
            for ($i = 0, $b = count($this->blocks); $i < $b; $i++) {
                $class = 'LarodsCoreBlocks\\' . trim($this->blocks[$i]);
                $classObj = new $class();
                $classObj->init();
            }
        });
    }

    public function addCategory()
    {
        add_action('block_categories', function ($categories) {
            return array_merge(
                $categories,
                [
                    [
                        'slug'  => 'larods-blocks',
                        'title' => __('Larods Blocks', 'larods-core'),
                    ],
                ]
            );
        }, 10, 2);
    }
}
