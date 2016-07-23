<?php

namespace App\CoreBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TextToDateTimeDataTransformer implements DataTransformerInterface
{
    // quand info revient de l'extérieur (base de données, url, fichier texte, etc.), à l'affichage du formulaire lors d'un edit
    public function transform($datetime)
    {
        if (null === $datetime) {
            return '';
        }

        if (!is_object($datetime)) {
            throw new TransformationFailedException('Expected a datetime.');
        }

        return $datetime->format('d').DIRECTORY_SEPARATOR.$datetime->format('m').DIRECTORY_SEPARATOR.$datetime->format('Y');

    }

    // quand le formulaire est soumis
    public function reverseTransform($stringDate)
    {
        if (null === $stringDate) {
            return NULL;
        }

        if (!is_string($stringDate)) {
            throw new TransformationFailedException('Expected a string.');
        }

        return \DateTime::createFromFormat('d/m/Y', $stringDate);
    }
}