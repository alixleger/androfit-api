<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ApiResource(
 *     attributes={
 *         "normalization_context"={"groups"={"meal:read"}},
 *         "denormalization_context"={"groups"={"meal:write"}}
 *     }
 * )
*/
class Meal
{
    /**
     * @Groups({"meal:read", "user:read"})
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
     * @Groups({"meal:read", "meal:write"})
     *
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="meals")
     *
     * @var User
    */
    private $creator;

    /**
     * @Groups({"meal:read", "meal:write", "user:read", "user:write"})
     *
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @var string
    */
    private $name;

    /**
     * @Groups({"meal:read", "meal:write", "user:read", "user:write"})
     *
     * @ORM\Column(name="date", type="datetime")
     *
     * @var DateTime
     */
    private $date;

    /**
     * @Groups({"meal:read", "meal:write", "user:read", "user:write"})
     *
     * @ORM\Column(name="description", type="string", length=1024)
     *
     * @var string
     */
    private $description;


    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Meal
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     * @return Meal
     */
    public function setDate(DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Meal
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function __toString() : string
    {
        return sprintf('%s - %s', $this->creator->getUsername(), $this->name);
    }

    /**
     * @return User|null
     */
    public function getCreator(): ?User
    {
        return $this->creator;
    }

    /**
     * @param User|null $user
     * @return Meal
     */
    public function setCreator(?User $user): self
    {
        $this->creator = $user;

        return $this;
    }
}
