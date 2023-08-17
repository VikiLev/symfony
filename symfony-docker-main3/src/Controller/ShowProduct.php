<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Entity\Order;

class ShowProduct extends AbstractController
{
    #[Route('/products/index')]
    public function show(EntityManagerInterface $entityManager): Response
    {
        $products = $entityManager->getRepository(Product::class)->findAll();
        $orders = $entityManager->getRepository(Order::class)->findAll();
        $sales = $this->getSalesByProductId($entityManager,1);
        return $this->render('products/index.html.twig', ['products' => $products,'orders' => $orders,'sales' => $sales]);
    }

    public function getSalesByProductId(EntityManagerInterface $entityManager, int $productId)
    {
        $product = $entityManager->getRepository(Product::class)->find($productId);
        $productPrice = $product->getPrice();
        $orders = $entityManager->getRepository(Order::class)->findBy(
            ['productId' => $productId]
        );

        $amount=0;
        foreach ($orders as $order){
            $amount += $order->getAmount();
        }
        return $productPrice * $amount;
    }
}
