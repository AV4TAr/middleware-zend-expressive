<?php

Namespace Application;

use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Zend\Expressive\Template\Twig;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\HtmlResponse;

class Formatter implements MiddlewareInterface
{

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $content = explode(',', $response->getBody());
        $accept = $request->getHeaderLine('accept');
        switch($accept){
            case 'application/json':
                return new JsonResponse($content, $response->getStatusCode());
                break;
            default:
                return new HtmlResponse($this->toHtml($content));
                break;
        }
    }

    /**
    * Add Twig
    */
    public function toHtml($content)
    {
        $twig = new Twig();
        $twig->addPath('views');
        return $twig->render('content.twig', ['content' => $content]);
        //return $content;
    }
}