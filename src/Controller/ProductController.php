<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController
{
    /**
     * Lista produktów
     */
    #[Route('/products', name: 'app_products_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $qb = $entityManager->createQueryBuilder()
            ->select('p')
            ->from(Product::class, 'p')
        ;
        $query = $qb->getQuery();
        $products = $query->getResult();

        return $this->render('product/list.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * Szczegóły produktu
     */
    #[Route('/products/{id}', name: 'app_products_show', requirements: ['id' => '\d+'])]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
