<?php

declare(strict_types=1);

namespace PhpChallenge\Infra\Http\Action;

use DI\Annotation\Inject;
use Laminas\Config\Config;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

final class DocAction
{
    /**
     * @Inject
     */
    private PhpRenderer $template;

    /**
     * @Inject("settings.swagger")
     */
    private string $swagger;

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        try {
            $viewData = [
                'spec' => json_encode(Yaml::parseFile($this->swagger)),
            ];

            return $this->template->render($response, 'docs/swagger.php', $viewData);
        } catch (ParseException) {
            return $this->template->render($response, 'docs/404.php');
        }
    }
}
