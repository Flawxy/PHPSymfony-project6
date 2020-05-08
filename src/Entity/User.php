<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
<<<<<<< Updated upstream
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
=======
<<<<<<< Updated upstream

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
=======
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("nickname",
 *     message="Un compte porte déjà ce pseudonyme !"
 * )
>>>>>>> Stashed changes
>>>>>>> Stashed changes
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message="Vous devez choisir un pseudonyme."
     * )
     */
    private ?string $nickname = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message="Veuillez renseigner un email valide."
     * )
     */
    private ?string $mail = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min=6,
     *     minMessage="Votre mot de passe doit comporter au moins 6 caractères."
     * )
     */
    private ?string $password = null;

    /**
     * @Assert\EqualTo(
     *     propertyPath="password",
     *     message="Les mots de passe indiqués ne correspondent pas."
     * )
     */
    public ?string $passwordConfirmation = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $profilePicture;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trick", mappedBy="creator")
     */
    private Collection $tricks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="author")
     */
    private Collection $comments;

    public function __construct()
    {
        $this->tricks = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

<<<<<<< Updated upstream
=======
<<<<<<< Updated upstream
=======
>>>>>>> Stashed changes
    /**
     * Assigns an image to an user when he registers
     *
     * @ORM\PrePersist()
     */
<<<<<<< Updated upstream
    protected function initializeProfilePicture()
=======
    public function initializeProfilePicture()
>>>>>>> Stashed changes
    {
        $picture = 'https://randomuser.me/api/portraits/lego/';

        $number = rand(0, 8);

        $picture .= $number . '.jpg';

        $this->profilePicture = $picture;

    }

<<<<<<< Updated upstream
=======
>>>>>>> Stashed changes
>>>>>>> Stashed changes
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?string $profilePicture): self
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    /**
     * @return Collection|Trick[]
     */
    public function getTricks(): Collection
    {
        return $this->tricks;
    }

    public function addTrick(Trick $trick): self
    {
        if (!$this->tricks->contains($trick)) {
            $this->tricks[] = $trick;
            $trick->setCreator($this);
        }

        return $this;
    }

    public function removeTrick(Trick $trick): self
    {
        if ($this->tricks->contains($trick)) {
            $this->tricks->removeElement($trick);
            // set the owning side to null (unless already changed)
            if ($trick->getCreator() === $this) {
                $trick->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * @inheritDoc
     */
    public function getSalt(){}

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->getNickname();
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials(){}
}
