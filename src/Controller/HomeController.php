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
        $qb->select('p.id, p.brand, p.model, p.price, p.description, p.imageUrl, p.colors, p.sizes,
            COUNT(po.id) AS opinionsCount, AVG(po.value) AS averageRating')
            ->from(ProductOpinion::class, 'po')
            ->leftJoin('po.idProduct', 'p')
            ->groupBy('po.idProduct')
            ->having('COUNT(po.id) > 3')
            ->andHaving('AVG(po.value) > 3')
            ->addOrderBy('averageRating', 'DESC')
            ->addOrderBy('opinionsCount', 'DESC')
            ->setMaxResults(3);

        $query = $qb->getQuery();
        $popularProducts = $query->getResult();

        foreach ($popularProducts as $key => $popularProduct) {
            $popularProducts[$key]['rating'] = number_format($popularProduct['averageRating'], 1, '.', '') . ' (' . $popularProduct['opinionsCount'] . ')';
        }

        return $this->render('home/index.html.twig', [
            'popularProducts' => $popularProducts
        ]);
    }
}
