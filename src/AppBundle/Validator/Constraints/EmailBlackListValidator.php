<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class EmailBlackListValidator extends ConstraintValidator
{
    private $blackList;

    public function setBlackList(array $blackList)
    {
        $this->blackList = $blackList;
    }

    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof EmailBlackList) {
            throw new UnexpectedTypeException($constraint, EmailBlackList::class);
        }

        $domainArray = preg_split("/@/", $value);
        if (count($domainArray) > 1) {
            $domain = $domainArray[1];
            if (!is_null($this->blackList) && in_array($domain, $this->blackList)) {
                $this->context->addViolation($constraint->message);
            }
        }
    }
}
