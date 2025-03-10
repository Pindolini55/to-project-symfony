<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart_show')]
    public function show(): Response
    {
        $cartItems = [
            ['id' => 1, 'name' => 'Smartphone X', 'price' => 1999, 'quantity' => 1],
            ['id' => 3, 'name' => 'Bezprzewodowe słuchawki', 'price' => 499, 'quantity' => 2],
        ];

        return $this->render('cart/show.html.twig', [
            'cartItems' => $cartItems
        ]);
    }
}
