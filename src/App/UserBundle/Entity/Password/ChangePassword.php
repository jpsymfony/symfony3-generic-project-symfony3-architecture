<?php

namespace App\UserBundle\Entity\Password;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Assert\Expression(
 *   expression="this.getOldPassword() !== this.getNewPassword()",
 *   message="Old password and new password must not be identical."
 * )
 */
class ChangePassword
{
    /**
     *
     * @var UserInterface
     */
    private $user;

    /**
     * @Assert\NotBlank
     * @Assert\Length(min=8, minMessage = "change_password.old_password.minlength")
     */
    private $oldPassword;

    /**
     * @Assert\NotBlank
     * @Assert\Length(min=8)
     */
    private $newPassword;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getSalt()
    {
        return $this->user->getSalt();
    }

    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;
    }

    public function getNewPassword()
    {
        return $this->newPassword;
    }

    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;
    }
}
