<?php

namespace AppBundle\Services;

use AppBundle\Services\Interfaces\PaymentManagerServiceInterface;

class PaymentManagerService implements PaymentManagerServiceInterface
{
    /**
     * @var PaymentContainerService 
     */
    private $paymentContainerService;

    /**
     * @inheritdoc
     */
    public function getPaymentClass($paymentClassLabel)
    {
        foreach ($this->paymentContainerService->getPaymentServices() as $paymentService)
        {
            if ($paymentService->isTypeMatch($paymentClassLabel)) {
                return $paymentService;
            }
        }

        throw new \Exception('None payment service found for class ' . $paymentClassLabel);
    }

    /**
     * @inheritdoc
     */
    public function setPaymentContainerService(PaymentContainerService $paymentContainerService)
    {
        $this->paymentContainerService = $paymentContainerService;
    }
}