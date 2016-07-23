<?php
namespace App\PortalBundle\Entity\Manager;

use App\CoreBundle\Entity\Manager\AbstractGenericManager;
use App\CoreBundle\Repository\AbstractGenericRepository;
use App\PortalBundle\Entity\Manager\Interfaces\HashTagManagerInterface;
use App\PortalBundle\Entity\Manager\Interfaces\ManagerInterface;
use App\PortalBundle\Repository\HashTagRepository;

class HashTagManager extends AbstractGenericManager implements HashTagManagerInterface, ManagerInterface
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
        return 'hashTagManager';
    }
}
