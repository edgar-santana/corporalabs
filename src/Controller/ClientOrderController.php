<?php

namespace App\Controller;

use App\Entity\ClientOrder;
use App\Entity\Product;
use App\Entity\Client;
use App\Entity\OrdersProducts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\ClientOrderType;

class ClientOrderController extends AbstractController{
    
    public function new(Request $request){
        $order = new ClientOrder();
        $title = "New Order";        

        $form = $this->createForm(ClientOrderType::class, $order);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $form_data = $request->request->get($form->getName());
            
            $product_id = $form_data["product"];
            $amount = (int)$form_data["amount"];
            $product = $this->getDoctrine()
                ->getRepository(Product::class)
                ->find($product_id);
            
            $cost = $amount * (float)$product->getPrice();
            $order->setCost($cost);
            
            $order_product = new OrdersProducts();
            $order_product->setClientOrders($order);
            $order_product->setProducts($product);
            $order_product->setAmount($amount);

            $em->persist($order);
            $em->persist($order_product);
            $em->flush();

            $this->addFlash('success', 'The order has been created.');

            return $this->redirectToRoute('client_order_new');
        }

        return $this->render('client_order/form.html.twig', [
            'form' => $form->createView(),
            'title' => $title,
        ]);
    }

    public function list(){
        $orders = $this->getDoctrine()
            ->getRepository(ClientOrder::class)
            ->findAll();
        
        return $this->render('client_order/list.html.twig', [
            'orders' => $orders,
        ]);
    }

    public function edit(Request $request, $id){
        $order = $this->getDoctrine()
            ->getRepository(ClientOrder::class)
            ->find($id);
        
        $current_order_products = $this->getDoctrine()
            ->getRepository(OrdersProducts::class)
            ->findBy(['client_orders' => $id]);
        $amount = !empty($current_order_products) ? $current_order_products[0]->getAmount() : 0;
        $product = !empty($current_order_products) ? $current_order_products[0]->getProducts() : null;

        $form = $this->createForm(ClientOrderType::class, $order);
        $form->get('product')->setData($product);
        $form->get('amount')->setData($amount);
        $form->get('cost')->setData($order->getCost());
        $title = "Edit Order nº ".$order->getId();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $form_data = $request->request->get($form->getName());

            $current_order_products = $this->getDoctrine()
                ->getRepository(OrdersProducts::class)
                ->findBy(['client_orders' => $id]);
            
            $product_id = $form_data["product"];
            $amount = (int)$form_data["amount"];
            $product = $this->getDoctrine()
                ->getRepository(Product::class)
                ->find($product_id);
            
            $cost = $amount * (float)$product->getPrice();
            $order->setCost($cost);
            
            $new_order_product = new OrdersProducts();
            $new_order_product->setClientOrders($order);
            $new_order_product->setProducts($product);
            $new_order_product->setAmount($amount);

            foreach($current_order_products as $order_product_to_delete){
                $em->remove($order_product_to_delete);
            }
            $em->flush();
            $em->persist($order);
            $em->persist($new_order_product);
            $em->flush();

            $this->addFlash('success', 'The order has been created.');

            return $this->redirectToRoute('client_order_list');
        }

        return $this->render('client_order/form.html.twig', [
            'form' => $form->createView(),
            'title' => $title,
        ]);
    }

    public function delete(Request $request, $id){
        $order_products = $this->getDoctrine()
            ->getRepository(OrdersProducts::class)
            ->find(['order_id' => $id]);
        
        $client = $this->getDoctrine()
            ->getRepository(ClientOrder::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($order_products);
        $em->remove($client);
        $em->flush();

        $this->addFlash('success', 'The client has been deleted.');

        return $this->redirectToRoute('client_list');
    }
}