<?php
namespace AppBundle\Entity\Manager;

use Jpsymfony\CoreBundle\Entity\Manager\AbstractGenericManager;
use Jpsymfony\CoreBundle\Repository\AbstractGenericRepository;
use AppBundle\Entity\Manager\Interfaces\HashTagManagerInterface;
use AppBundle\Entity\Manager\Interfaces\ManagerInterface;

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
