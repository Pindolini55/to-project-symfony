<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "wp_product")]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    public ?string $name = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    public ?string $price = null;

    #[ORM\Column(type: "text", nullable: true)]
    public ?string $description = null;

    #[ORM\Column(type: "array", nullable: true)]
    public ?array $colors = null;

    // Gettery i settery

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function getColors(): ?array
    {
        return $this->colors;
    }

    public function setColors(?array $colors): void
    {
        $this->colors = $colors;
    }

}
