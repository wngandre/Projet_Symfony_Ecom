<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session): Response
    {
        // Récupérer le panier depuis la session
        $cart = $session->get('cart', []);

        return $this->render('cart/index.html.twig', [
            'mycart_name' => 'My Cart',
            'cart' => $cart,
        ]);
    }

#[Route('/cart/add/{id}', name: 'app_add_to_cart')]
public function addToCart($id, EntityManagerInterface $em, SessionInterface $session): Response
{
    $product = $em->getRepository(Product::class)->find($id);
    if (!$product) {
        $this->addFlash('error', 'Produit introuvable');
        return $this->redirectToRoute('app_cart');
    }
    $cart = $session->get('cart', []);
    $cart[$id] = [
        'title' => $product->getTitle(),
        'content' => $product->getContent(),
        'image' => $product->getImage(),
    ];
    $session->set('cart', $cart);
    $this->addFlash('success', 'Produit ajouté au panier');
    return $this->redirectToRoute('app_cart');
}

    #[Route('/cart/remove/{id}', name: 'app_remove_from_cart')]
    public function removeFromCart($id, SessionInterface $session): Response
    {
        // Récupérer le panier depuis la session
        $cart = $session->get('cart', []);

        // Supprimer le produit du panier
        if (isset($cart[$id])) {
            unset($cart[$id]);
            $this->addFlash('success', 'Produit retiré du panier');
        } else {
            $this->addFlash('error', 'Produit introuvable dans le panier');
        }

        // Sauvegarder le panier mis à jour dans la session
        $session->set('cart', $cart);

        return $this->redirectToRoute('app_cart');
    }
}