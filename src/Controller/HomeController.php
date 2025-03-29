<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $qb = $entityManager->createQueryBuilder()
            ->select('p')
            ->from(Product::class, 'p')
        ;
        $query = $qb->getQuery();
        $products = $query->getResult();

        return $this->render('home/index.html.twig', [
            'products' => $products
        ]);
    }
}
