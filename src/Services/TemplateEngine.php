<?php

namespace ResumeCraft\Services;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TemplateEngine
{

    /**
     * @return Environment
     */
    public function twig(): Environment
    {
        $loader = new FilesystemLoader($this->getTemplatesPath());
        return new Environment($loader, [
            'cache' => false, // Set to '../cache/' if you want to use cache
        ]);
    }

    /**
     * @return string
     */
    private function getTemplatesPath(): string
    {
        return PROJECT_ROOT . '/resources/templates';
    }

    /**
     * @return array
     */
    public function getTemplateList() : array
    {
        return array_diff(scandir($this->getTemplatesPath()), array('.', '..'));
    }
}