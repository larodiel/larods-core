<?php

namespace LarodsCoreApp\Contracts;

interface Blocks
{
    public function initTemplateEngine();
    public function getBlockJsonPath(): string;
    public function registerBlock();
    public function renderBlock(array $attributes): string;
    public function init();
}
