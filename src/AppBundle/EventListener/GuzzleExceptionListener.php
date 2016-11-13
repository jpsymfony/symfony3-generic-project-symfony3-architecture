<?php
namespace AppBundle\EventListener;

use AppBundle\Services\PaymentContainerService;
use GuzzleHttp\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class GuzzleExceptionListener
 */
class GuzzleExceptionListener
{
    /**
     * @var PaymentContainerService $paymentContainerService
     */
    private $paymentContainerService;

    private $fail = false;


    /**
     * GuzzleExceptionListener constructor.
     * @param PaymentContainerService $paymentContainerService
     */
    public function __construct(PaymentContainerService $paymentContainerService)
    {
        $this->paymentContainerService = $paymentContainerService;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($exception instanceof BadResponseException) {
            $this->fail = true;
            $response   = new JsonResponse(array('success' => false));
            $event->setResponse($response);
        }
    }

    public function onKernelTerminate()
    {
        if (false === $this->fail) {
            return;
        }

        $this->paymentContainerService->addFail();
    }
}