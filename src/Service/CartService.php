<?php
//
//namespace App\Service;
//
//
//
//use App\Entity\Product;
//use Doctrine\ORM\EntityManagerInterface;
//use Symfony\Component\HttpFoundation\RequestStack;
//use Symfony\Component\HttpFoundation\Session\SessionInterface;
//
//class CartService {
//    private  RequestStack $requestStack;
//    private EntityManagerInterface $entityManager;
//    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
//    {
//        $this->RequestStack = $requestStack;
//    }
//
//    public function addToCart($id): void
//    {
//        $cart = $this->RequestStack->getSession()->get('cart', []);
//        if (!empty($cart[$id])){
//            $cart[$id]++;
//        }else{
//            $cart[$id] = 1;
//        }
//        $this->getSession()->set('cart', $cart);
//    }
//
//
//    public function getTotal(): array
//    {
//        $cart = $this->getSession()->get('cart');
//        $cartData = [];
//        foreach ($cart as $id => $quantity){
//            $product = $this->entityManager->getRepository(Product::class)->findOneBy(['id' => $id]);
//            if (!$product){
//
//            }
//            $cartData[] = [
//                'product' => $product,
//                'quantity' => $quantity
//            ];
//        }
//        return $cartData;
//    }
//    private function getSession(): SessionInterface
//    {
//        return $this->RequestStack->getSession();
//    }
//}