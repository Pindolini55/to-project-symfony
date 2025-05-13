<?php

namespace App\Service;
use App\Entity\Product;
use App\Entity\ProductOpinion;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class HandrunFunctions
{
    protected $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addProducts ($output, $numberOfProducts, $withOpinions = false) {
        if ($withOpinions) {
            $output->writeln('<question>Dodawanie ' .  $numberOfProducts .   ' produktów z opiniami</question>');
        } else {
            $output->writeln('<question>Dodawanie ' .  $numberOfProducts .   ' produktów</question>');
        }

        $productsBrands = array('Adidas', 'Nike', 'Puma', 'Reebok', 'New Balance', 'Salomon', 'Asics', 'Mizuno', 'Saucony', 'Brooks',
            'Hoka One One', 'On Running', 'Altra', 'Merrell', 'Scarpa', 'La Sportiva', 'Salewa', 'Lowa', 'Keen',
            'Columbia', 'The North Face', 'Mountain Hardwear', 'Black Diamond', 'Mammut',
            'Patagonia', 'Montbell', 'Outdoor Research');
        $productsModels = array('X1', 'X2', 'X3', 'X4', 'X5', 'Z1', 'Z2', 'Z3', 'Z4', 'Z5', 'Jump I', 'Jump II', 'Jump III',
            'Run I', 'Run II', 'Run III', 'Run IV', 'Run V', 'Sport I', 'Sport II', 'Sport III', 'Sport IV', 'Sport V', 'Enigma I',
            'Enigma II', 'Enigma III', 'Enigma IV', 'Enigma V', 'Ultra I', 'Ultra II', 'Ultra III', 'Ultra IV', 'Ultra V',
            'Performance I', 'Performance II', 'Performance III', 'Performance IV', 'Performance V',
            'Speed I', 'Speed II', 'Speed III', 'Speed IV', 'Speed V', 'Power I', 'Power II', 'Power III', 'Power IV',
            'Prime I', 'Prime II', 'Prime III', 'Prime IV', 'Prime V',
            'Pro I', 'Pro II', 'Pro III', 'Pro IV', 'Pro V', 'Max I', 'Max II', 'Max III', 'Max IV', 'Max V',
            'Force I', 'Force II', 'Force III', 'Force IV', 'Force V',
            'Flex I', 'Flex II', 'Flex III', 'Flex IV', 'Flex V',
            'Energy I', 'Energy II', 'Energy III', 'Energy IV', 'Energy V',
            'Drive I', 'Drive II', 'Drive III', 'Drive IV', 'Drive V',
            'Dynamic I', 'Dynamic II', 'Dynamic III', 'Dynamic IV', 'Dynamic V',
            'Fusion I', 'Fusion II', 'Fusion III', 'Fusion IV', 'Fusion V',
            'Impact I', 'Impact II', 'Impact III', 'Impact IV', 'Impact V',
            'Motion I', 'Motion II', 'Motion III', 'Motion IV', 'Motion V',
            'Revolution I', 'Revolution II', 'Revolution III', 'Revolution IV', 'Revolution V',
            'Speedster I', 'Speedster II', 'Speedster III', 'Speedster IV', 'Speedster V',
            'Stamina I', 'Stamina II', 'Stamina III', 'Stamina IV', 'Stamina V',
            'Stride I', 'Stride II', 'Stride III', 'Stride IV', 'Stride V',
            'Surge I', 'Surge II', 'Surge III', 'Surge IV', 'Surge V',
        );
        $productsDescriptions = array(
            'Lekkie sneakersy idealne na codzienne spacery po mieście.',
            'Eleganckie skórzane półbuty, które doskonale pasują do garnituru.',
            'Wygodne buty sportowe zaprojektowane z myślą o biegaczach.',
            'Modne trampki w stylu retro, idealne na każdą okazję.',
            'Trwałe buty trekkingowe na wymagające górskie szlaki.',
            'Stylowe sandały na lato z miękką wkładką i regulowanymi paskami.',
            'Wytrzymałe kozaki ocieplane naturalną wełną na mroźne dni.',
            'Klasyczne baleriny, które sprawdzą się w pracy i na co dzień.',
            'Nowoczesne buty do koszykówki z amortyzowaną podeszwą.',
            'Zamszowe mokasyny w casualowym stylu na spotkania z przyjaciółmi.',
            'Buty do fitnessu zapewniające doskonałą przyczepność i stabilizację.',
            'Wodoodporne botki na jesień z antypoślizgową podeszwą.',
            'Luksusowe szpilki na specjalne okazje, wykonane z naturalnej skóry.',
            'Przewiewne espadryle na lato, dostępne w wielu kolorach.',
            'Buty robocze z metalowym noskiem i wzmocnioną konstrukcją.'
        );
        $productColors = array('black', 'green', 'white', 'blue', 'brown', 'red', 'yellow', 'purple', 'pink', 'orange', 'beige', 'navy', 'teal', 'burgundy');
        $productSizes = array('30, 31, 32, 33, 34, 35, 36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46');

        $opinionsArray = array(
            'Buty są bardzo wygodne, idealne na długie spacery!',
            'Świetna jakość wykonania, skóra miękka i przyjemna.',
            'Trochę twarda podeszwa, ale ogólnie buty prezentują się świetnie.',
            'Kolor w rzeczywistości jeszcze ładniejszy niż na zdjęciach.',
            'Buty są lekkie, ale solidne – dokładnie czego szukałam.',
            'Idealne na lato, stopa się w nich nie poci.',
            'Rozmiar zgodny z opisem, nic nie obciera.',
            'Bardzo wygodne od pierwszego założenia!',
            'Mogłyby być trochę szersze, ale po kilku dniach noszenia się dopasowały.',
            'Świetne na treningi, dobrze trzymają kostkę.',
            'Po kilku miesiącach użytkowania nadal wyglądają jak nowe.',
            'Buty są bardzo stylowe i przyciągają uwagę.',
            'Mega wygodne, a do tego bardzo lekkie!',
            'Świetny stosunek jakości do ceny.',
            'Na deszczowe dni sprawdzają się znakomicie – w 100% wodoodporne.',
            'Buty są ciepłe, ale nie przegrzewają stóp.',
            'Trochę śliskie na mokrej nawierzchni, trzeba uważać.',
            'Świetnie wykonane detale, widać dbałość o każdy szczegół.',
            'Dostarczone szybko i starannie zapakowane.',
            'Bardzo wygodne do pracy stojącej – nogi mniej się męczą.',
            'Materiał oddychający – idealne do biegania latem.',
            'Rozmiar wypada trochę mniejszy, warto zamówić numer większe.',
            'Wygodne zarówno na co dzień, jak i na bardziej eleganckie wyjścia.',
            'Podeszwa elastyczna, dobrze amortyzuje wstrząsy.',
            'Łatwe w czyszczeniu i odporne na zabrudzenia.',
        );


        for ($i = 1; $i <= $numberOfProducts; $i++) {
            $randBrands = rand(0, 26);
            $randModels = rand(0, 126);
            $randPrice = rand(150, 1500);
            $randDescription = rand(0, 14);
            $product = new Product();
            $product->setBrand($productsBrands[$randBrands]);
            $product->setModel($productsModels[$randModels]);
            $product->setPrice($randPrice);
            $product->setDescription($productsDescriptions[$randDescription]);
            $product->setImageUrl(null);
            $colorsToAdd = array();
            $randColors = rand(1,4);
            for ($j = 1; $j <= $randColors; $j++) {
                $randedColor = rand(0, 13);
                if (!in_array($productColors[$randedColor], $colorsToAdd)) {
                    $colorsToAdd[] = $productColors[$randedColor];
                }
            }
            $min = rand(30, 44);
            $max = $min + rand(1, 7);
            $sizesToAdd = array();
            for ($s = $min; $s <= $max; $s++) {
                if (!in_array($productSizes[$j], $sizesToAdd)) {
                    $sizesToAdd[] = $s;
                }
            }
            $product->setColors($colorsToAdd);
            $product->setSizes($sizesToAdd);
            $this->entityManager->persist($product);
            if ($withOpinions) {
                $this->addProductsOpinions($product, $opinionsArray);
            }
        }

        try {
            $this->entityManager->flush();
        } catch (Exception $exception) {
            dump($exception->getMessage());
        }
    }

    public function addProductsOpinions(Product $product, $opinionsArray = array()): void{
        if (empty($opinionsArray)) {
            $opinionsArray = array(
                'Buty są bardzo wygodne, idealne na długie spacery!',
                'Świetna jakość wykonania, skóra miękka i przyjemna.',
                'Trochę twarda podeszwa, ale ogólnie buty prezentują się świetnie.',
                'Kolor w rzeczywistości jeszcze ładniejszy niż na zdjęciach.',
                'Buty są lekkie, ale solidne – dokładnie czego szukałam.',
                'Idealne na lato, stopa się w nich nie poci.',
                'Rozmiar zgodny z opisem, nic nie obciera.',
                'Bardzo wygodne od pierwszego założenia!',
                'Mogłyby być trochę szersze, ale po kilku dniach noszenia się dopasowały.',
                'Świetne na treningi, dobrze trzymają kostkę.',
                'Po kilku miesiącach użytkowania nadal wyglądają jak nowe.',
                'Buty są bardzo stylowe i przyciągają uwagę.',
                'Mega wygodne, a do tego bardzo lekkie!',
                'Świetny stosunek jakości do ceny.',
                'Na deszczowe dni sprawdzają się znakomicie – w 100% wodoodporne.',
                'Buty są ciepłe, ale nie przegrzewają stóp.',
                'Trochę śliskie na mokrej nawierzchni, trzeba uważać.',
                'Świetnie wykonane detale, widać dbałość o każdy szczegół.',
                'Dostarczone szybko i starannie zapakowane.',
                'Bardzo wygodne do pracy stojącej – nogi mniej się męczą.',
                'Materiał oddychający – idealne do biegania latem.',
                'Rozmiar wypada trochę mniejszy, warto zamówić numer większe.',
                'Wygodne zarówno na co dzień, jak i na bardziej eleganckie wyjścia.',
                'Podeszwa elastyczna, dobrze amortyzuje wstrząsy.',
                'Łatwe w czyszczeniu i odporne na zabrudzenia.',
            );
        }
        $randOpinions = rand(1, 15);
        for ($i = 1; $i <= $randOpinions; $i++) {
            $randedOpinion = rand(0, 24);
            $productOpinion = new ProductOpinion();
            $productOpinion->setIdProduct($product);
            $productOpinion->setValue(rand(1, 5));
            $productOpinion->setDescription($opinionsArray[$randedOpinion]);
            $this->entityManager->persist($productOpinion);
        }
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
        $colors = array('black', 'green', 'white', 'blue', 'brown', 'red', 'yellow', 'purple', 'pink', 'orange', 'beige', 'navy', 'teal', 'burgundy');

        foreach ($products as $product) {
            $colorsToAdd = array();
            $randColors = rand(1,3);
            for ($i = 1; $i <= $randColors; $i++) {
                $randedColor = rand(0, 13);
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