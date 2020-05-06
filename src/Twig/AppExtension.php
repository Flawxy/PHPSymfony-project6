<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions() : array
    {
        return [
            new TwigFunction('isMediaAnImage', [$this, 'isMediaAnImage']),
        ];
    }

    /**
     * Allows to differentiate images and videos
     *
     * @param string $url
     * @return bool
     */
    public function isMediaAnImage(string $url) : bool
    {
        if(strpos($url, '.jpg') !== false) {
            return true;
        }
        if(strpos($url, '.jpeg') !== false) {
            return true;
        }
        if(strpos($url, '.png') !== false) {
            return true;
        }
        if(strpos($url, '.gif') !== false) {
            return true;
        }
        if(strpos($url, '.svg') !== false) {
            return true;
        }

        return false;
    }
}