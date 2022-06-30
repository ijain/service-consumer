<?php

namespace ListRestAPI\Listener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();

        if (strpos($exception->getMessage(), 'No route found') !== false) {
            $code = Response::HTTP_NOT_FOUND;
        } else {
            $code = $exception->getCode();
        }

        $message = [
            'message' => $exception->getMessage(),
            'code' => $code
        ];

        // Customize your response object to display the exception details
        $response = new Response();
        $response->setContent(json_encode(['error' => $message]));

        // HttpExceptionInterface
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($code);
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // sends the modified response object to the event
        $event->setResponse($response);
    }
}
