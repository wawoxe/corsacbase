<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class MaintanceSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly bool $maintanceMode,
    ) {
    }

    public function onKernelResponse(RequestEvent $event): void
    {
        if ($this->maintanceMode === true) {
            $event->setResponse((new Response())->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE));
            $event->stopPropagation();
        }
    }

    /**
     * @return array<string, array<string, int>>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                ['onKernelResponse', PHP_INT_MAX - 1000],
            ],
        ];
    }
}
