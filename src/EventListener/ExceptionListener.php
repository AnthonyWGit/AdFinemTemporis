<?php
// src/EventListener/ExceptionListener.php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class ExceptionListener
{
    private $twig;
    private $requestStack;

    public function __construct(Environment $twig, RequestStack $requestStack)
    {
        $this->twig = $twig;
        $this->requestStack = $requestStack;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getThrowable();
        if ($exception instanceof NotFoundHttpException) {
            // Render your custom 404 error page
            $response = new Response($this->twig->render('bundles/TwigBundle/Exception/error404.html.twig'));
            $event->setResponse($response);
        } elseif ($exception instanceof ForeignKeyConstraintViolationException) {
            // Render your custom 500 error page
            $response = new Response($this->twig->render('bundles/TwigBundle/Exception/error500.html.twig'));
            $event->setResponse($response);
        }

        // Access the flashbag
        $session = $this->requestStack->getSession();
        $flashbag = $session->getFlashBag();

        // Empty the flashbag
        foreach ($flashbag->all() as $messages) {
            foreach ($messages as $message) {
                // Process each message if needed
            }
        }
    }
}
