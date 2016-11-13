<?php

namespace AppBundle\Services;

abstract class AbstractPaymentService implements GenericPaymentServiceInterface
{
    /**
     * @inheritDoc
     */
    abstract public function getHtml($url, $parameters, $displaySubmitBtn, $message);

    /**
     * @inheritDoc
     */
    abstract function addFail();

    /**
     * @inheritdoc
     */
    public function isTypeMatch($labelClass)
    {
        return $labelClass === $this->getLabel();
    }

    /**
     * @inheritDoc
     */
    abstract function getLabel();

}