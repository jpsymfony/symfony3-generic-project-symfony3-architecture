<?php

namespace AppBundle;

use AppBundle\DependencyInjection\CompilerPass\PaymentCompilerPass;
use AppBundle\DependencyInjection\CompilerPass\ManagerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new PaymentCompilerPass());
        $container->addCompilerPass(new ManagerCompilerPass);
    }

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
