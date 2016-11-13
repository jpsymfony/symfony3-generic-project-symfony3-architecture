<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HashTagCollectionType extends AbstractType
{
    private $configMaxLimitHashTag;

    public function __construct($configMaxLimitHashTag = null)
    {
        $this->configMaxLimitHashTag = $configMaxLimitHashTag;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'entry_type' => HashTagType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'max_hashtag_limit' => $this->configMaxLimitHashTag,
                'by_reference' => false,
                'prototype' => true,
                'delete_empty' => true,
                'attr' => [
                    'class' => 'table table-stripped',
                ],
            )
        );

    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        // this value is passed to the view so it can be used in javascript
        $view->vars['max_limit'] = $options['max_hashtag_limit'];
    }

    public function getParent()
    {
        return CollectionType::class;
    }
}