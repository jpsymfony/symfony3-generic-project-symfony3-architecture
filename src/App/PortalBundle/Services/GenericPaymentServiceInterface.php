<?php

namespace App\PortalBundle\Services;


interface GenericPaymentServiceInterface
{
    /**
     * @param $url
     * @param $parameters
     * @param $displaySubmitBtn
     * @param $message
     * @return mixed
     */
    public function getHtml($url, $parameters, $displaySubmitBtn, $message);

    /**
     * @return mixed
     */
    public function addFail();

    /**
     * @param $labelClass
     * @return GenericPaymentServiceInterface
     */
    public function isTypeMatch($labelClass);

    /**
     * @return string LabelClass
     */
    public function getLabel();
}