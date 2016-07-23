<?php
namespace App\PortalBundle\Entity\Manager;

use App\CoreBundle\Entity\Manager\AbstractGenericManager;
use App\CoreBundle\Repository\AbstractGenericRepository;
use App\PortalBundle\Entity\Manager\Interfaces\CategoryManagerInterface;
use App\PortalBundle\Entity\Manager\Interfaces\ManagerInterface;
use App\PortalBundle\Repository\CategoryRepository;

class CategoryManager extends AbstractGenericManager implements CategoryManagerInterface, ManagerInterface
{
    /**
     * @inheritdoc
     */
    public function __construct(AbstractGenericRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return 'categoryManager';
    }
}
