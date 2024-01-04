<?php

declare(strict_types=1);

namespace App\Helper;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Helper for creating and validating responses.
 *
 * @author Mykyta Melnyk <wawoxeq@gmail.com>
 */
final class ResponseHelper
{
    public const HTML_TYPE = 'html';
    public const JSON_TYPE = 'json';

    /**
     * @var array<int, string> $types
     */
    private array $types = [self::HTML_TYPE, self::JSON_TYPE];

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly Environment $twig,
    ) {
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function createResponse(string $type, int $code): Response
    {
        $this->responseTypeIsValid($type);

        $response = match ($type) {
            // Return rendered maintenance.html.twig template as HTTP response.
            self::HTML_TYPE => new Response($this->twig->render('pages/maintenance.html.twig')),
            // JSON Response as default.
            default => new JsonResponse([]),
        };

        $response->setStatusCode($code);

        return $response;
    }

    /**
     * Avoid triggering by listeners on sub-requests.
     */
    public function isMainRequest(ResponseEvent $event): bool
    {
        return $event->isMainRequest() || $this->requestStack->getMainRequest() !== null;
    }

    /**
     * Response type validation.
     */
    private function responseTypeIsValid(string $type): void
    {
        if (in_array($type, $this->types, true) === false) {
            throw new InvalidArgumentException('[ResponseHelper] Response type is not valid.');
        }
    }
}
