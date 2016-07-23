<?php

namespace App\PortalBundle;

use App\PortalBundle\DependencyInjection\CompilerPass\PaymentCompilerPass;
use App\PortalBundle\DependencyInjection\CompilerPass\ManagerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppPortalBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new PaymentCompilerPass());
        $container->addCompilerPass(new ManagerCompilerPass);
    }
}
