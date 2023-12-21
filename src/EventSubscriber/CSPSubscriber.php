<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Helper\CSPHelper;
use App\Helper\ResponseHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class CSPSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly ResponseHelper $responseHelper,
        private readonly CSPHelper $CSPHelper,
    ) {
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if ($this->responseHelper->isMainRequest($event) === false) {
            return;
        }

        $event->setResponse($this->CSPHelper->setHeaders($event->getResponse()));
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
