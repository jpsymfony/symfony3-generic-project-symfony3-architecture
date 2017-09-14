<?php

namespace AppBundle\Validator;

use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ContactValidator
{
    public static function validate($object, ExecutionContextInterface $context, $payload)
    {
        if ($object->getKnowledge() == 'autre' && $object->getOther() == null) {
            $context->buildViolation(
                "Vous devez remplir ce champ si vous avez coché 'autre'"
            )
                    ->atPath('other')
                    ->addViolation();
        }

        $propertyAccessor = new PropertyAccessor();

        $nbNullFields = 0;
        $fields = explode(',', $payload);

        foreach ($fields as $field) {
            if (null === $propertyAccessor->getValue($object, $field))
            {
                $nbNullFields++;
            }
        }

        if ($nbNullFields >= count($fields)) {
            $context->buildViolation(
                    sprintf("Vous devez remplir au moins l'un de ces deux champs: %s", $payload)
                )
                    ->addViolation();
        }
    }
}