<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[AsController]
class ApiSales extends AbstractController
{
    #[Route('/api/sales/{productId}', name: 'api_sales')]
    public function __invoke(EntityManagerInterface $entityManager, int $productId): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($productId);

        if (!$product){
            return new Response("There is no product with this ID");
        }
        $productPrice = $product->getPrice();
        $productName = $product->getName();
        $orders = $entityManager->getRepository(Order::class)->findBy(
            ['productId' => $productId]
        );

        $amount = 0;
        foreach ($orders as $order) {
            $amount += $order->getAmount();
        }
        $totalSalesAmount = $productPrice * $amount;

        return new Response((string) "Name ".$productName." Sold Amount ".$amount." Sold Summ ".$totalSalesAmount);
    }
}

