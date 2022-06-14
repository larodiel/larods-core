<?php

namespace LarodsCoreBlocks;

class BlockTemplateRender
{
    public $template;

    public function initTemplateEngine()
    {
        $loader = new \Twig\Loader\FilesystemLoader([
            __DIR__
        ]);

        $this->template = new \Twig\Environment($loader, [
            //'cache' => LRD_CORE_PATH . '/cache',
        ]);
    }

    public function renderTemplate($templateName, $dir = '', $vars = [])
    {
        return $this->template->render(basename($dir) . '/views/' . $templateName, $vars);
    }
}
