<?php
/**
 * Created by PhpStorm.
 * User: johnsaulnier
 * Date: 05/03/2016
 * Time: 00:00
 */

namespace AppBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ManagerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('app.manager_container_service')) {
            return;
        }

        $definition = $container->findDefinition(
            'app.manager_container_service'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'app.manager_services'
        );
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'addManager',
                array(new Reference($id))
            );
        }
    }
}