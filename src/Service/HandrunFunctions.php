<?php

namespace App\Service;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class HandrunFunctions
{
    protected $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function addProductColors($output): void
    {
        $output->writeln('<question>Dodawanie kolorów do produktów</question>');
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('p')
            ->from(Product::class, 'p')
        ;
        $query = $qb->getQuery();
        $products = $query->getResult();
        $colors = array('black', 'green', 'grey', 'white', 'blue', 'brown');

        foreach ($products as $product) {
            $colorsToAdd = array();
            $randColors = rand(1,3);
            for ($i = 1; $i <= $randColors; $i++) {
                $randedColor = rand(0, 5);
                if (!in_array($colors[$randedColor], $colorsToAdd)) {
                    $colorsToAdd[] = $colors[$randedColor];
                }
            }
            $product->setColors($colorsToAdd);
            $this->entityManager->persist($product);
        }

        try {
            $this->entityManager->flush();
        } catch (Exception $exception) {
            dump($exception->getMessage());
        }
    }
}