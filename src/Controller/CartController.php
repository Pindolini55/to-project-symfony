<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart_show')]
    public function show(): Response
    {
        return $this->render('cart/show.html.twig', [
        ]);
    }

    #[Route('/cart/save', name: 'app_cart_save', methods: ['POST'])]
    public function save(Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), true);
        $cart = $data['cart'] ?? [];
        $idProducts = array_column($cart, 'id');
        $cartProducts = array();
        if (!empty($idProducts)) {
        $qb = $entityManager->createQueryBuilder();
            $qb->select('p.id, p.brand, p.model, p.price, p.description, p.imageUrl, p.colors, p.sizes')
                ->from(Product::class, 'p')
                ->where($qb->expr()->in('p.id', $idProducts))
            ;
            $query = $qb->getQuery();
            $cartProducts = $query->getResult();
        }

        return new Response(
            json_encode($cartProducts),
            200,
            array('content-type' => 'application/json')
        );
    }
}
