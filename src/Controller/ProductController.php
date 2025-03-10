<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * Lista produktów
     */
    #[Route('/products', name: 'app_products_list')]
    public function list(): Response
    {
        $products = [
            ['id' => 1, 'name' => 'Smartphone X', 'price' => 1999],
            ['id' => 2, 'name' => 'Laptop Pro', 'price' => 3999],
            ['id' => 3, 'name' => 'Bezprzewodowe słuchawki', 'price' => 499],
        ];

        return $this->render('product/list.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * Szczegóły produktu
     */
    #[Route('/products/{id}', name: 'app_products_show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        $product = [
            'id' => $id,
            'name' => 'Przykładowy produkt ' . $id,
            'price' => 123,
            'description' => 'Opis produktu o ID ' . $id,
        ];

        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
