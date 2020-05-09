<?php

namespace App\Entity;

use App\Repository\PasswordUpdateRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class PasswordUpdate
{
    private ?string $oldPassword = null;

    /**
     * @Assert\Length(
     *     min=6,
     *     minMessage="Votre mot de passe doit comporter au moins 6 caractères."
     * )
     */
    private ?string $newPassword = null;

    /**
     * @Assert\EqualTo(
     *     propertyPath="newPassword",
     *     message="Les mots de passe indiqués ne correspondent pas."
     * )
     */
    private ?string $confirmPassword = null;


    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
