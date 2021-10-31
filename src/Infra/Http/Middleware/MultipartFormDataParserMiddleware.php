<?php

declare(strict_types=1);

namespace PhpChallenge\Infra\Http\Middleware;

use Nyholm\Psr7\UploadedFile;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Riverline\MultiPartParser\Converters\PSR7 as MultiPartParser;

class MultipartFormDataParserMiddleware implements MiddlewareInterface
{
    private const CONTENT_TYPE = 'multipart/form-data';

    public function __construct(private ServerRequestFactoryInterface $requestFactory)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $handler->handle($this->parse($request));
    }

    private function parse(ServerRequestInterface $request): ServerRequestInterface
    {
        $parsed = MultiPartParser::convert($request);

        if (!$parsed->isMultiPart()) {
            return $request;
        }

        $files = [];
        foreach ($parsed->getParts() as $part) {
            if ($part->isFile()) {
                $errorStatus = UPLOAD_ERR_OK;
                $partBody = $part->getBody();
                $files[] = new UploadedFile(
                    $partBody,
                    mb_strlen($partBody, '8bit'),
                    $errorStatus,
                    $part->getFileName(),
                    $part->getMimeType()
                );
                continue;
            }
            break;
        }

        if (empty($part)) {
            return $request->withUploadedFiles($files);
        }

        $postRequest = $this->requestFactory->createServerRequest($request->getMethod(), $request->getUri());
        foreach ($part->getHeaders() as $key => $value) {
            $postRequest->withHeader($key, $value);
        }
        $postRequest->getBody()->write($part->getBody());

        return $postRequest->withUploadedFiles($files);
    }
}
