<?php
namespace AppBundle\Security;

use AppBundle\Entity\Movie;
use AppBundle\Entity\Interfaces\UserInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class MovieVoter extends Voter
{
    const EDIT = 'edit';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
    }

    private function canEdit(Movie $movie, UserInterface $user)
    {
    }
}