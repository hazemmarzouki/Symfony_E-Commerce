<?php

namespace App\Controller;

use App\Entity\Order;
use App\Classe\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderValidateController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    #[Route('/commande/merci', name: 'app_order_validate')]
    public function index( Cart $cart): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findAll();;
        $cart->remove();

        
        return $this->render('order_validate/index.html.twig',[
            'order'=> $order
        ]);
        
    }
}
