<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MediaRepository::class)
 */
class Media
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"cards_list", "card_detail"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"cards_list", "card_detail"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"cards_list", "card_detail"})
     */
    private $size;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"cards_list", "card_detail"})
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"cards_list", "card_detail"})
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"cards_list", "card_detail"})
     */
    private $safeName;

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

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getSafeName(): ?string
    {
        return $this->safeName;
    }

    public function setSafeName(string $safeName): self
    {
        $this->safeName = $safeName;

        return $this;
    }
}
