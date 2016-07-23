<?php
/**
 * Created by PhpStorm.
 * User: johnsaulnier
 * Date: 05/03/2016
 * Time: 00:00
 */

namespace App\PortalBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class PaymentCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('app_portal.payment_container_service')) {
            return;
        }

        $definition = $container->findDefinition(
            'app_portal.payment_container_service'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'app_portal.payment_services'
        );
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'addPaymentService',
                array(new Reference($id))
            );
        }
    }
}