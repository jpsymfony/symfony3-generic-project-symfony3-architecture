<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MovieFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title', TextType::class, array('label' => 'film.titre'))
                ->add('category', EntityType::class, array(
                    'class' => 'AppBundle\Entity\Category',
                    'multiple' => false,
                    'required' => false,
                    'label' => 'film.categorie',
                    'placeholder' => 'film.categories.toutes',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->orderBy('c.title', 'ASC');
                    },
                ))
                ->add('actors', EntityType::class, array(
                    'class' => 'AppBundle\Entity\Actor',
                    'multiple' => true,
                    'required' => false,
                    'label' => 'film.acteurs',
                    'placeholder' => 'film.acteurs.tous',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                            ->orderBy('a.lastName', 'ASC');
                    },
                ))
                ->add('hashTags', EntityType::class, array(
                    'class' => 'AppBundle\Entity\HashTag',
                    'multiple' => true,
                    'required' => false,
                    'label' => 'film.hashtags',
                    'placeholder' => 'film.prix.tous',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                            ->orderBy('p.name', 'ASC');
                    },
                ))
                ->add('description', TextType::class, array(
                    'label' => 'film.description',
                ))
                ->add('releaseDateFrom', BirthdayType::class, array('mapped' => false, 'years' => range(date('Y') - 50, date('Y'))))
                ->add('releaseDateTo', BirthdayType::class, array('mapped' => false, 'years' => range(date('Y') - 50, date('Y'))));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'AppBundle\Entity\Movie',
                'csrf_protection' => false,
        ));
    }
}
