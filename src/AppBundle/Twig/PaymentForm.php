<?php

namespace AppBundle\Twig;

use AppBundle\Services\GenericPaymentServiceInterface;
use AppBundle\Services\PaymentManagerService;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class PaymentForm extends \Twig_Extension
{

    /**
     * @var string $url
     */
    private $url = null;

    /**
     * @var string $defaultPaymentOrganism
     */
    private $defaultPaymentOrganism = null;
    /**
     * @var PaymentManagerService
     */
    private $paymentManagerService;

    public function __construct(PaymentManagerService $paymentManagerService, $configPayment)
    {
        $this->paymentManagerService = $paymentManagerService;
        $this->defaultPaymentOrganism = ucfirst($configPayment['default']);
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

    public function setUrl($configPayment)
    {
        if (!isset($configPayment[$this->defaultPaymentOrganism])) {
            throw new NotFoundResourceException('no configPayment for ' . $this->defaultPaymentOrganism);
        }

        $this->url = $configPayment[$this->defaultPaymentOrganism]['url'];
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

        return $paymentSolution->getHtml($this->url, $parameters, $displaySubmitBtn, $message);
    }

}
