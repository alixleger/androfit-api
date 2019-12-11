<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ApiResource(
 *     attributes={
 *         "normalization_context"={"groups"={"friend_request:read"}},
 *         "denormalization_context"={"groups"={"friend_request:write"}}
 *     }
 * )
 */
class FriendRequest
{
    /**
     * @Groups({"friend_request:read", "user:read"})
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @var int
    */
    private $id;

    /**
     * @ApiSubresource(maxDepth=1)
     *
     * @Groups({"friend_request:read", "friend_request:write"})
     *
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="friendRequests")
     *
     * @var User
    */
    private $user;

    /**
     * @Groups({"friend_request:read", "friend_request:write", "user:read", "user:write"})
     *
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @var bool|null
     */
    private $accepted;

    /**
     * @ApiSubresource(maxDepth=2)
     *
     * @Groups({"friend_request:read", "friend_request:write", "user:read", "user:write"})
     *
     * @ORM\ManyToOne(targetEntity=User::class)
     *
     * @var User
     */
    private $friend;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return FriendRequest
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isAccepted(): ?bool
    {
        return $this->accepted;
    }

    /**
     * @param bool|null $accepted
     * @return FriendRequest
     */
    public function setAccepted(?bool $accepted): self
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * @return User
     */
    public function getFriend(): User
    {
        return $this->friend;
    }

    /**
     * @param User $friend
     * @return FriendRequest
     */
    public function setFriend(User $friend): self
    {
        $this->friend = $friend;

        return $this;
    }


}
