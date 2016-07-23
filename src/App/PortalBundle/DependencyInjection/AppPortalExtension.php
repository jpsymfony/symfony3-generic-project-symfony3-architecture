<?php

namespace App\PortalBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AppPortalExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('mail_blacklist.yml');
        $loader->load('validator.yml');
        $loader->load('repository.yml');
        $loader->load('manager.yml');
        $loader->load('form.yml');

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('twig.xml');
        $loader->load('services.xml');
        $loader->load('listener.xml');

        $container->setParameter('app_portal.max_hashtag_limit', $config['max_hashtag_limit']);
        $container->setParameter('app_portal.max_movies_per_page', $config['max_movies_per_page']);
        $container->setParameter('app_portal.max_actors_per_page', $config['max_actors_per_page']);
        $container->setParameter('app_portal.payment_organisms', $config['payment_organisms']);
    }
}
