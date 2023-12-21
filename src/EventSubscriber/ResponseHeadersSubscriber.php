<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Helper\CSPHelper;
use App\Helper\ResponseHelper;
use App\Helper\SecurityHeadersHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ResponseHeadersSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly ResponseHelper $responseHelper,
        private readonly CSPHelper $CSPHelper,
        private readonly SecurityHeadersHelper $securityHeadersHelper,
    ) {
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if ($this->responseHelper->isMainRequest($event) === false) {
            return;
        }

        // Set up Content-Security-Policy Subscriber. See csp.yaml
        $event->setResponse($this->CSPHelper->setCSPHeader($event->getResponse()));
        // Set up security headers. See security_headers.yaml
        $event->setResponse($this->securityHeadersHelper->setSecurityHeaders($event->getResponse()));
    }

    /**
     * @return array<string, array<string, int>>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => [
                ['onKernelResponse', PHP_INT_MAX - 1000], // Set up max priority
            ],
        ];
    }
}
