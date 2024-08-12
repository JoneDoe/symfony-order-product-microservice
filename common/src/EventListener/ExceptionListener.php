<?php

declare(strict_types=1);

namespace SharedBundle\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Exception\ValidatorException;

class ExceptionListener
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable()->getPrevious() ?? $event->getThrowable();

        $error = match (true) {
            $exception instanceof ValidationFailedException => $this->exceptionTransformer(
                $exception->getViolations()
            ),
            $exception instanceof NotFoundHttpException => 'Source not found!',
            $exception instanceof HttpExceptionInterface => $exception->getMessage(),
            default => 'Something went wrong!',
        };

        $response = new JsonResponse();

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);

            $this->logger->error($exception->getMessage());
        }

        $response->setData(['errors' => $error]);

        $event->setResponse($response);
    }

    private function exceptionTransformer(ConstraintViolationList $violations): array
    {
        $errors = [];

        foreach ($violations as $violation) {
            $errors[] = [
                'property' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
            ];
        }

        return $errors;
    }
}