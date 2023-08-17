<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddOrders extends AbstractController
{
    #[Route('/order', name: 'create_order')]
    public function createOrder(EntityManagerInterface $entityManager): Response
    {
        $order = new Order();
        $order->setProductId(1);
        $order->setAmount(3);

        // tell Doctrine you want to (eventually) save the order (no queries yet)
        $entityManager->persist($order);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new order with id '.$order->getId());
    }
}
