<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ApiResource(
 *     attributes={
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     }
 * )
 */
class User implements UserInterface
{
    /**
     * @Groups({"read"})
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Unique()
     *
     * @Groups({"read", "write"})
     *
     * @ORM\Column(type="string", unique=true)
     *
     * @var string
     */
    private $username;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=500)
     *
     * @var string
     */
    private $password;

    /**
     * @Groups({"read", "write"})
     *
     * @ORM\Column(name="is_active", type="boolean")
     *
     * @var bool
     */
    private $isActive;

    /**
     * @ApiSubresource(maxDepth=1)
     *
     * @Groups({"read", "write"})
     *
     * @ORM\OneToMany(targetEntity=Session::class, mappedBy="creator", orphanRemoval=true)
     *
     * @var ArrayCollection
     */
    private $createdSessions;

    /**
     * @ApiSubresource(maxDepth=1)
     *
     * @Groups({"read", "write"})
     *
     * @ORM\OneToMany(targetEntity=Meal::class, mappedBy="creator", orphanRemoval=true)
     *
     * @var ArrayCollection
     */
    private $meals;

    /**
     * @ApiSubresource(maxDepth=1)
     *
     * @Groups({"read", "write"})
     *
     * @ORM\OneToMany(targetEntity=FriendRequest::class, mappedBy="user", orphanRemoval=true)
     *
     * @var ArrayCollection
     */
    private $friendRequests;

    public function __construct()
    {
        $this->createdSessions = new ArrayCollection;
        $this->friendRequests  = new ArrayCollection;
        $this->meals           = new ArrayCollection;
        $this->isActive        = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername() : ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

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

    /**
     * @return Collection|Session[]
     */
    public function getCreatedSessions(): Collection
    {
        return $this->createdSessions;
    }

    /**
     * @param Session $session
     * @return $this
     */
    public function addSession(Session $session): self
    {
        if (!$this->createdSessions->contains($session)) {
            $this->createdSessions->add($session);
            $session->setCreator($this);
        }

        return $this;
    }

    /**
     * @param Session $session
     * @return $this
     */
    public function removeSession(Session $session): self
    {
        if ($this->createdSessions->contains($session)) {
            $this->createdSessions->removeElement($session);
            if ($session->getCreator() === $this) {
                $session->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Meal[]
     */
    public function getMeals(): Collection
    {
        return $this->meals;
    }

    /**
     * @param Meal $meal
     * @return $this
     */
    public function addMeal(Meal $meal): self
    {
        if (!$this->meals->contains($meal)) {
            $this->meals->add($meal);
            $meal->setCreator($this);
        }

        return $this;
    }

    /**
     * @param Meal $meal
     * @return $this
     */
    public function removeMeal(Meal $meal): self
    {
        if ($this->meals->contains($meal)) {
            $this->meals->removeElement($meal);
            if ($meal->getCreator() === $this) {
                $meal->setCreator(null);
            }
        }

        return $this;
    }

    public function getRoles() : array
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    public function getSalt()
    {
        return null;
    }

    public function __toString() : string
    {
        return $this->username;
    }

    /**
     * @return Collection|FriendRequest[]
     */
    public function getFriendRequests(): Collection
    {
        return $this->friendRequests;
    }

    /**
     * @param FriendRequest $friendRequest
     * @return $this
     */
    public function addFriendRequest(FriendRequest $friendRequest): self
    {
        if (!$this->friendRequests->contains($friendRequest)) {
            $this->friendRequests->add($friendRequest);
            $friendRequest->setUser($this);
        }

        return $this;
    }

    /**
     * @param FriendRequest $friendRequest
     * @return $this
     */
    public function removeFriendRequest(FriendRequest $friendRequest): self
    {
        if ($this->friendRequests->contains($friendRequest)) {
            $this->friendRequests->removeElement($friendRequest);
            if ($friendRequest->getUser() === $this) {
                $friendRequest->setUser(null);
            }
        }

        return $this;
    }
}
