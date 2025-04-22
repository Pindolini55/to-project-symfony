<?php

namespace App\Controller;

use App\Entity\ProductOpinion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $qb = $entityManager->createQueryBuilder();
        $qb->select('p.id as idProduct, p.name, p.price, p.description, p.imageUrl, p.colors,
            COUNT(po.id) AS opinionsCount, AVG(po.value) AS averageRating')
            ->from(ProductOpinion::class, 'po')
            ->leftJoin('po.idProduct', 'p')
            ->groupBy('po.idProduct')
            ->orderBy('opinionsCount', 'DESC')
            ->setMaxResults(3);

        $query = $qb->getQuery();
        $popularProducts = $query->getResult();

        foreach ($popularProducts as $key => $popularProduct) {
            $popularProducts[$key]['rating'] = number_format($popularProduct['averageRating'], 1, '.', '') . ' (' . $popularProduct['opinionsCount'] . ')';
        }

        return $this->render('home/index.html.twig', [
            'popularProducts' => $popularProducts
        ]);



        // Przykładowe produkty do sekcji "Our Popular Products"
        $popularProducts = [
            [
                'name' => 'Nike Dunk Low Retro',
                'colors' => array('red', 'blue', 'green'),
                'price' => '$134.98',
//                'rating' => '4.3 (3.2k)',
                'imageUrl' => 'images/nike1.png',
            ],
            [
                'name' => 'Nike Air 402',
                'colors' => array('black'),
                'price' => '$134.98',
//                'rating' => '4.3 (3.2k)',
                'imageUrl' => 'images/nike2.png',
            ],
            [
                'name' => 'Nike 03 Air Force',
                'colors' => array('white'),
                'price' => '$134.98',
//                'rating' => '4.3 (3.2k)',
                'imageUrl' => 'images/nike3.png',
            ]
        ];

        // Przykładowe produkty do sekcji "Best Shoes Collection"
        $bestCollection = [
            [
                'name' => 'Nike ZoomX',
                'color' => '1 COLOR',
                'price' => '$129.99',
                'rating' => '4.5 (2.1k)',
                'image' => 'images/nike-zoomx.png',
            ],
            [
                'name' => 'Nike Air Max',
                'color' => '1 COLOR',
                'price' => '$149.99',
                'rating' => '4.7 (5.1k)',
                'image' => 'images/nike-air-max.png',
            ],
            [
                'name' => 'Nike Jordan 1',
                'color' => '1 COLOR',
                'price' => '$179.99',
                'rating' => '4.9 (6.3k)',
                'image' => 'images/nike-jordan-1.png',
            ],
        ];

        return $this->render('home/index.html.twig', [
            'popularProducts' => $popularProducts,
            'bestCollection' => $bestCollection,
        ]);
    }
}
