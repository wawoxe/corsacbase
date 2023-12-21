<?php

declare(strict_types=1);

namespace App\Helper;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersHelper
{
    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
    ) {
    }

    /**
     * Set up security headers.
     * Configure values in security_headers.yaml
     */
    public function setSecurityHeaders(Response $response): Response
    {
        $CSPParameters = $this->parameterBag->get('security_headers');

        foreach ($CSPParameters as $header => $value) {
            $response->headers->set($header, $value);
        }

        return $response;
    }
}
