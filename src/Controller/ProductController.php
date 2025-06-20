<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductOpinion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController
{
    /**
     * Lista produktów
     */
    #[Route('/products', name: 'app_products_list')]
    public function list(Request $request, EntityManagerInterface $entityManager): Response
    {
        $minPrice = $request->query->get('minPrice');
        $maxPrice = $request->query->get('maxPrice');
        $sizes = $request->query->all('size');
        $colors = $request->query->all('color');
        $sortBy = $request->query->get('sort');
        $qb = $entityManager->createQueryBuilder()
            ->select('p.id, p.brand, p.model, p.price, p.description, p.imageUrl, p.colors, p.sizes')
            ->from(Product::class, 'p')
            ->setMaxResults(1200)
        ;
        if ($sortBy === 'price_asc') {
            $qb->orderBy('p.price', 'ASC');
        } else if ($sortBy === 'price_desc') {
            $qb->orderBy('p.price', 'DESC');
        }
        if (!empty($minPrice) && is_numeric($minPrice)) {
            $qb->andWhere('p.price >= :minPrice');
            $qb->setParameter('minPrice', $minPrice);
        }
        if (!empty($maxPrice) && is_numeric($maxPrice)) {
            $qb->andWhere('p.price <= :maxPrice');
            $qb->setParameter('maxPrice', $maxPrice);
        }
        if (!empty($sizes)) {
            $orX = $qb->expr()->orX();
            foreach ($sizes as $size) {
                $orX->add($qb->expr()->like('p.sizes', $qb->expr()->literal('%' . $size . '%')));
            }
            $qb->andWhere($orX);
        }
        if (!empty($colors)) {
            $orX = $qb->expr()->orX();
            foreach ($colors as $color) {
                $orX->add($qb->expr()->like('p.colors', $qb->expr()->literal('%' . $color . '%')));
            }
            $qb->andWhere($orX);
        }
        $query = $qb->getQuery();
        $products = $query->getResult();
        foreach ($products as $key => $product) {
            $products[$key]['averageRating'] = 0;
            $products[$key]['averageRatingSum'] = 0;
            $products[$key]['opinionsCount'] = rand(0, 15);
            if ($products[$key]['opinionsCount'] > 0) {
                for ($i = 0; $i < $products[$key]['opinionsCount']; $i++) {
                    $products[$key]['averageRating'] += rand(1, 5);
                }
            }
//            foreach ($productsOpinions as $opinion) {
//                if ($product['id'] == $opinion['idProduct']) {
//                    $products[$key]['averageRating'] += $opinion['value'];
//                    $products[$key]['opinionsCount']++;
//                }
//            }
            if ($products[$key]['opinionsCount'] > 0) {
                $products[$key]['rating'] = number_format($products[$key]['averageRating'] / $products[$key]['opinionsCount'], 1, '.', '') . ' (' . $products[$key]['opinionsCount'] . ')';
                $products[$key]['averageRatingSum'] = $products[$key]['averageRating'] / $products[$key]['opinionsCount'];
            } else {
                $products[$key]['rating'] = '0 (0)';
            }
        }
        if ($sortBy === 'popular_desc') {
            usort($products, function ($a, $b) {
                return $b['opinionsCount'] <=> $a['opinionsCount']
                    ?: $b['averageRatingSum'] <=> $a['averageRatingSum'];
            });
        } else if ($sortBy === 'rating_desc') {
            usort($products, function ($a, $b) {
                return $b['averageRatingSum'] <=> $a['averageRatingSum']
                    ?: $b['opinionsCount'] <=> $a['opinionsCount'];
            });
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
        $qb = $entityManager->createQueryBuilder()
            ->select('po.id, po.value, po.description, p.id as idProduct')
            ->from(ProductOpinion::class, 'po')
            ->leftJoin('po.idProduct', 'p')
            ->where('p.id = ' . $id)
        ;
        $query = $qb->getQuery();
        $productOpinions = $query->getResult();

        $product->averageRating = 0;
        $product->averageRatingSum = 0;
        $product->opinionsCount = 0;
        foreach ($productOpinions as $opinion) {
            $product->averageRating += $opinion['value'];
            $product->opinionsCount++;
        }
        if ($product->opinionsCount > 0) {
            $product->rating = number_format($product->averageRating / $product->opinionsCount, 1, '.', '') . ' (' . $product->opinionsCount . ')';
            $product->averageRatingSum = $product->averageRating / $product->opinionsCount;
        } else {
            $product->rating = '0 (0)';
        }

        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
