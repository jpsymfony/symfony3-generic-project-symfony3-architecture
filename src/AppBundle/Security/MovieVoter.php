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
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::EDIT))) {
            return false;
        }

        // only vote on Movie objects inside this voter
        if (!$subject instanceof Movie) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            // the user must be logged in; if not, deny access
            return false;
        }

        $movie = $subject;

        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }

        switch($attribute) {
            case self::EDIT:
                return $this->canEdit($movie, $user);
            default: break;
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Movie $movie, UserInterface $user)
    {
        if (!is_object($user)) {
            return false;
        }

        if ($movie->getAuthor() === $user) {
            return true;
        }

        return false;
    }
}