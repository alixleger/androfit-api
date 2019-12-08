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
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     }
 * )
*/
class Session
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
     * @ApiSubresource(maxDepth=1)
     *
     * @Groups({"read", "write"})
     *
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="createdSessions")
     *
     * @var User
    */
    private $creator;

    /**
     * @Groups({"read", "write"})
     *
     * @ORM\Column(name="name", type="string")
     *
     * @var string
    */
    private $name;

    /**
     * @Groups({"read", "write"})
     *
     * @ORM\Column(name="location", type="string", length=64)
     *
     * @var string
     */
    private $location;

    /**
     * @Groups({"read", "write"})
     *
     * @ORM\Column(name="begin_date", type="datetime")
     *
     * @var DateTime
     */
    private $beginDate;

    /**
     * @Groups({"read", "write"})
     *
     * @ORM\Column(name="end_date", type="datetime")
     *
     * @var DateTime
     */
    private $endDate;

    /**
     * @Groups({"read", "write"})
     *
     * @ORM\Column(name="description", type="string", length=512)
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
     * @return Session
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return Session
     */
    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getBeginDate(): DateTime
    {
        return $this->beginDate;
    }

    /**
     * @param DateTime $beginDate
     * @return Session
     */
    public function setBeginDate(DateTime $beginDate): self
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    /**
     * @param DateTime $endDate
     * @return Session
     */
    public function setEndDate(DateTime $endDate): self
    {
        $this->endDate = $endDate;

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
     * @return Session
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
     * @return Session
     */
    public function setCreator(?User $user): self
    {
        $this->creator = $user;

        return $this;
    }
}
