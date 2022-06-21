<?php

namespace App\Classe;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private $entityManager;
    private $session;
    public function __construct(SessionInterface $session , EntityManagerInterface $entityManager)
    {   
        $this->entityManager=$entityManager;
        $this->session = $session;
    }

    public function add($id)
    {

        $cart = $this->session->get('cart', []);
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        $this->session->set('cart', $cart);
    }

    public function get()
    {
        return $this->session->get('cart');
    }

    public function remove()
    {
        return $this->session->remove('cart');
    }
    public function delete($id)
    {
        $cart = $this->session->get('cart', []);
        unset($cart[$id]);

        return $cart = $this->session->set('cart', $cart);
    }
    public function decrease($id)
    {
        $cart = $this->session->get('cart', []);
        if ($cart[$id] > 1) {
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }
        return $cart = $this->session->set('cart', $cart);
    }
    public function getFull(){
        $cartDeatil = [];

        if($this->get()){
        foreach ($this->get() as $id => $quantity) {
            $ProductObject = $this->entityManager->getRepository(Product::class)->findOneById($id);
            if (!$ProductObject) {
                $this->delete($id);
                continue;
            } 
            
            $cartDeatil[] = [
                'product' => $ProductObject , 
                'quantity' => $quantity

            ];
        }}
        return $cartDeatil;
      
    }
}
