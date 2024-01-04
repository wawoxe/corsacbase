<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Helper\ResponseHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class MaintenanceSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly ResponseHelper $responseHelper,
        private readonly bool $maintenanceMode,
        private string $maintenanceType,
    ) {
        $this->maintenanceType = strtolower($this->maintenanceType);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        if ($this->maintenanceMode !== true) {
            return;
        }

        $event->setResponse(
            $this->responseHelper->createResponse(
                $this->maintenanceType,
                Response::HTTP_SERVICE_UNAVAILABLE
            )
        );
        $event->stopPropagation();
    }

    /**
     * @return array<string, array<string, int>>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                ['onKernelRequest', PHP_INT_MAX - 1000], // Set up max priority
            ],
        ];
    }
}
