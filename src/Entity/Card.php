<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\{Category, Fx};

/**
 * @ORM\Entity(repositoryClass=CardRepository::class)
 */
class Card
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"cards_list", "card_detail"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\Length(min=2,max=60)
     * @Groups({"cards_list", "card_detail"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"cards_list", "card_detail"})
     */
    private $value;

    /**
     * @ORM\Column(type="text")
     * @Groups({"card_detail"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=category::class, inversedBy="cards")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"cards_list", "card_detail"})
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=fx::class, inversedBy="cards")
     * @Groups({"cards_list", "card_detail"})
     */
    private $fx;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"card_detail"})
     */
    private $frontImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"card_detail"})
     */
    private $backImage;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     * @Groups({"card_detail"})
     */
    private $color;

    public function __construct()
    {
        $this->fx = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?category
    {
        return $this->category;
    }

    public function setCategory(?category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, fx>
     */
    public function getFx(): Collection
    {
        return $this->fx;
    }

    public function addFx(fx $fx): self
    {
        if (!$this->fx->contains($fx)) {
            $this->fx[] = $fx;
        }

        return $this;
    }

    public function removeFx(fx $fx): self
    {
        $this->fx->removeElement($fx);

        return $this;
    }

    public function getFrontImage(): ?string
    {
        return $this->frontImage;
    }

    public function setFrontImage(?string $frontImage): self
    {
        $this->frontImage = $frontImage;

        return $this;
    }

    public function getBackImage(): ?string
    {
        return $this->backImage;
    }

    public function setBackImage(?string $backImage): self
    {
        $this->backImage = $backImage;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
