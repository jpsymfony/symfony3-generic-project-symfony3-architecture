<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class EmailBlackList extends Constraint
{
    public $message = 'Les services de mails jetables ne sont pas autorisés.';

    public function validatedBy()
    {
        return 'email_black_list';
    }
}
