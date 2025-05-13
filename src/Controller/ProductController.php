<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductOpinion;
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
            ->select('p.id, p.brand, p.model, p.price, p.description, p.imageUrl, p.colors, p.sizes')
            ->from(Product::class, 'p')
        ;
        $query = $qb->getQuery();
        $products = $query->getResult();

        $qb = $entityManager->createQueryBuilder()
            ->select('po.id, po.value, po.description, p.id as idProduct')
            ->from(ProductOpinion::class, 'po')
            ->leftJoin('po.idProduct', 'p')
        ;
        $query = $qb->getQuery();
        $productsOpinions = $query->getResult();



        foreach ($products as $key => $product) {
            $products[$key]['averageRating'] = 0;
            $products[$key]['opinionsCount'] = 0;
            foreach ($productsOpinions as $opinion) {
                if ($product['id'] == $opinion['idProduct']) {
                    $products[$key]['averageRating'] += $opinion['value'];
                    $products[$key]['opinionsCount']++;
                }
            }
            if ($products[$key]['opinionsCount'] > 0) {
                $products[$key]['rating'] = number_format($products[$key]['averageRating'] / $products[$key]['opinionsCount'], 1, '.', '') . ' (' . $products[$key]['opinionsCount'] . ')';
            } else {
                $products[$key]['rating'] = '0 (0)';
            }
        }
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
