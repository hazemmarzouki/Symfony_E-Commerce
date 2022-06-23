<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use DateTimeImmutable;
use App\Form\OrderType;
use App\Entity\OrderDetails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/commande', name: 'order')]
    public function index(Cart $cart, Request $request): Response
    {
        if (!$this->getUser()->getAddresses()->getValues()) {
            return $this->redirectToRoute('account_address_add');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);
    }


    #[Route('/commande/recap', name: 'order_recap', methods:"POST")]
    public function add(Cart $cart, Request $request ): Response
    {


        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $date=new DateTimeImmutable();
            $order = new Order();
            $carriers = $form->get('Carriers')->getData();
            $delivrey =$form->get('Addresses')->getData();

            $delivrey_content=$delivrey->getFirstname().' '.$delivrey->getLastname();
            $delivrey_content .= '<br/>'.$delivrey->getphone();

            if($delivrey->getCompany()){
                $delivrey_content .='<br/>'.$delivrey->getCompany();
            }

            $delivrey_content .='<br/>'.$delivrey->getAddress();
            $delivrey_content .='<br/>'.$delivrey->getCodePostal().'- '.$delivrey->getCity().'-'.$delivrey->getCountry();
            ;

            //Save Order()
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrix());
            $order->setDelivrey($delivrey_content);
            $order->setIsPaid(0);

            $this->entityManager->persist($order);

          //save OrderDeatils()

            foreach($cart->getFull() as $product){

                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);

                $this->entityManager->persist($orderDetails);
            }
            $this->entityManager->flush();

            
        return $this->render('order/add.html.twig', [
            'cart' => $cart->getFull(),
            'carrier'=> $carriers,
            'delivrey'=>$delivrey_content
        ]);
        }
        return $this->redirectToRoute('cart');
    }
}
