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
    public ?string $brand = null;

    #[ORM\Column(type: "string", length: 255)]
    public ?string $model = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    public ?string $price = null;

    #[ORM\Column(type: "text", nullable: true)]
    public ?string $description = null;

    #[ORM\Column(type: "array", nullable: true)]
    public ?array $colors = null;

    #[ORM\Column(type: "array", nullable: true)]
    public ?array $sizes = null;

    // Gettery i settery

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): void
    {
        $this->brand = $brand;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): void
    {
        $this->model = $model;
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

    public function getSizes(): ?array
    {
        return $this->sizes;
    }

    public function setSizes(?array $sizes): void
    {
        $this->sizes = $sizes;
    }


}
