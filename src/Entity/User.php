<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("nickname",
 *     message="Un compte porte déjà ce pseudonyme !"
 * )
 * @UniqueEntity("mail",
 *     message="Un compte associé à cette adresse mail existe déjà !"
 * )
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
     *     normalizer="trim",
     *     message="Vous devez choisir un pseudonyme."
     * )
     * @Assert\Regex(
     *     pattern="/^[a-z0-9]+$/i",
     *     message="Votre pseudonyme ne peut comporter que des caractères alphanumériques !"
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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $confirmationToken = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $resetToken = null;

    public function __construct()
    {
        $this->tricks = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * Assigns a token to an user when he registers
     *
     * @ORM\PrePersist()
     * @throws Exception
     */
    public function initializeToken()
    {
        $randomString = random_bytes(10);

        $token = md5($randomString);

        $this->confirmationToken = $token;
    }

    /**
     * Assigns an image to an user when he registers
     *
     * @ORM\PrePersist()
     */
    public function initializeProfilePicture()
    {
        $picture = 'https://randomuser.me/api/portraits/lego/';

        $number = rand(0, 8);

        $picture .= $number . '.jpg';

        $this->profilePicture = $picture;
    }

    public function createResetPasswordToken()
    {
        $randomString = random_bytes(10);

        $token = md5($randomString);

        $this->resetToken = $token;
    }

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

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(?string $confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }
}
