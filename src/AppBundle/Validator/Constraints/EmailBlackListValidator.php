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

        //TODO
    }
}
