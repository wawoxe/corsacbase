<?php

declare(strict_types=1);

namespace App\Helper;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Set up CSP headers from csp.yaml
 *
 * @author Mykyta Melnyk <wawoxeq@gmail.com>
 */
final class CSPHelper
{
    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
    ) {
    }

    /**
     * Set up Content-Security-Policy headers.
     * Configure values in csp.yaml
     */
    public function setCSPHeader(Response $response): Response
    {
        $CSPParameters = $this->parameterBag->get('csp');
        $CSPHeaderValue = '';

        foreach ($CSPParameters as $parameter => $values) {
            $CSPHeaderValue .= sprintf('%s %s; ', $parameter, implode(' ', $values));
        }

        $response->headers->set('Content-Security-Policy', rtrim($CSPHeaderValue));

        return $response;
    }
}
