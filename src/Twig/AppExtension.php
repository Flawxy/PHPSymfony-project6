<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters() : array
    {
        return [
            new TwigFilter('truncate', [$this, 'truncate']),
        ];
    }

    /**
     * Custom Twig filter to truncate a string
     * @param string $text
     * @param int $length
     * @param string $append
     * @return string
     */
    public function truncate(string $text, int $length, string $append): string
    {
        if (strlen($text) > $length) {
            return mb_substr($text, 0, $length, 'UTF-8') . $append;
        }
        return $text;
    }
}
