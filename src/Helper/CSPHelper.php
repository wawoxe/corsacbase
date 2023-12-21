<?php

declare(strict_types=1);

namespace App\Helper;

use Symfony\Component\HttpFoundation\Response;

class CSPHelper
{
    /**
     * Set up Content-Security-Policy headers.
     * Configure values in csp.yaml
     */
    public function setHeaders(Response $response): Response
    {
        // TODO: get parameters from csp.yaml and configure CSP

        return $response;
    }
}
