<?php

declare(strict_types=1);

namespace App\Helper;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseHelper
{
    public const HTML_TYPE = 'html';
    public const JSON_TYPE = 'json';

    /**
     * @var array<int, string> $types
     */
    private array $types = [self::HTML_TYPE, self::JSON_TYPE];

    public function createResponse(string $type, int $code): Response
    {
        $this->responseTypeIsValid($type);

        $response = $type === self::HTML_TYPE ? new Response() : new JsonResponse([]);
        $response->setStatusCode($code);

        return $response;
    }

    private function responseTypeIsValid(string $type): void
    {
        if (in_array($type, $this->types, true) === false) {
            throw new InvalidArgumentException('[ResponseHelper] Response type is not valid.');
        }
    }
}
