<?php

namespace App\Services;

use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

class HtmlSanitizerService
{
    protected HtmlSanitizer $sanitizer;

    public function __construct()
    {
        $config = (new HtmlSanitizerConfig())
            ->allowSafeElements()
            ->allowLinkSchemes(['http', 'https', 'mailto'])
            ->allowRelativeLinks()
            ->allowRelativeMedias();

        $this->sanitizer = new HtmlSanitizer($config);
    }

    /**
     * Clean untrusted HTML string to prevent XSS attacks while preserving formatting.
     */
    public function clean(?string $html): string
    {
        if (empty($html)) {
            return '';
        }

        return $this->sanitizer->sanitize($html);
    }
}
