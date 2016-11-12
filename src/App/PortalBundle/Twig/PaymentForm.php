<?php

namespace App\PortalBundle\Twig;

use App\PortalBundle\Services\GenericPaymentServiceInterface;
use App\PortalBundle\Services\PaymentManagerService;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class PaymentForm extends \Twig_Extension
{
    /**
     * @var string $defaultPaymentOrganism
     */
    private $defaultPaymentOrganism = null;
    /**
     * @var PaymentManagerService
     */
    private $paymentManagerService;

    /**
     * @var array
     */
    private $configPayment;

    public function __construct(PaymentManagerService $paymentManagerService, $configPayment)
    {
        $this->paymentManagerService = $paymentManagerService;
        $this->configPayment = $configPayment;
        $this->defaultPaymentOrganism = ucfirst($this->configPayment['default']);

    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('payment_form', array($this ,'getPaymentForm')),
        );
    }

    public function getName()
    {
        return 'payment_form';
    }

    public function getPaymentForm($values, $displaySubmitBtn, $message)
    {
        $clientId = $values['client_id'];
        $description = $values['description'];
        $orderId = $values['order_id'];
        $amount = intval($values['amount'] * 100);

        $parameters = array(
            'AMOUNT' => $amount,
            'CLIENTIDENT' => $clientId,
            'DESCRIPTION' => $description,
            'ORDERID' => $orderId,
        );

        $paymentSolution = $this->paymentManagerService->getPaymentClass($this->defaultPaymentOrganism);

        if (!$paymentSolution instanceof GenericPaymentServiceInterface) {
            throw new NotFoundResourceException('no GenericPaymentService found for ' . $this->defaultPaymentOrganism);
        }

        var_dump($paymentSolution);

        return $paymentSolution->getHtml($this->getUrl(), $parameters, $displaySubmitBtn, $message);
    }

    private function getUrl()
    {
        if (!isset($this->configPayment[$this->defaultPaymentOrganism])) {
            throw new NotFoundResourceException('no configPayment for ' . $this->defaultPaymentOrganism);
        }

        return $this->configPayment[$this->defaultPaymentOrganism]['url'];
    }

}
