<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SportRepository::class)]
#[ApiResource]
class Sport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, SportType>
     */
    #[ORM\ManyToMany(targetEntity: SportType::class)]
    private Collection $sportType;

    public function __construct()
    {
        $this->sportType = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, SportType>
     */
    public function getSportType(): Collection
    {
        return $this->sportType;
    }

    public function addSportType(SportType $sportType): static
    {
        if (!$this->sportType->contains($sportType)) {
            $this->sportType->add($sportType);
        }

        return $this;
    }

    public function removeSportType(SportType $sportType): static
    {
        $this->sportType->removeElement($sportType);

        return $this;
    }

}
