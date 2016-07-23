<?php

namespace App\CoreBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DatedmYToDateYmdViewTransformer implements DataTransformerInterface
{
    // quand info revient de l'extérieur (base de données, url, fichier texte, etc.), à l'affichage du formulaire lors d'un edit
    public function transform($stringDate)
    {
        // we already have the date format we want from url so we do nothing
        return;
    }

    // quand le formulaire est soumis
    public function reverseTransform($stringDate)
    {
        if (empty($stringDate)) {
            return null;
        }

        if (!is_string($stringDate)) {
            throw new TransformationFailedException('Expected a string.');
        }

        $stringDateParts = explode('-', $stringDate);

        // we want Y-m-d format for doctrine request
        return $stringDateParts[2] . '-' . $stringDateParts[1]. '-' . $stringDateParts[0];

    }
}