<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "wp_product_opinion")]
class ProductOpinion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "integer", nullable: false)]
    public ?int $value = 1;

    #[ORM\Column(type: "text", nullable: true)]
    public ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'opinions')]
    #[ORM\JoinColumn(name: 'id_product', referencedColumnName: 'id', nullable: false)]
    private ?Product $idProduct = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(?int $value): void
    {
        $this->value = $value;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getIdProduct(): ?Product
    {
        return $this->idProduct;
    }

    public function setIdProduct(?Product $idProduct): void
    {
        $this->idProduct = $idProduct;
    }


}
