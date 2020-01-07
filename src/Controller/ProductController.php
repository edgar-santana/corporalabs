<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\ProductType;

class ProductController extends AbstractController{
    
    public function new(Request $request){
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $title = "New Product";

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'The product has been created.');

            return $this->redirectToRoute('product_new');
        }

        return $this->render('product/form.html.twig', [
            'form' => $form->createView(),
            'title' => $title,
        ]);
    }

    public function list(){
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();
        
        return $this->render('product/list.html.twig', [
            'products' => $products,
        ]);
    }

    public function edit(Request $request, $id){
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        $form = $this->createForm(ProductType::class, $product);
        $title = "Edit Product: ".$product->getName();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'The product has been changed.');

            return $this->redirectToRoute('product_edit',["id"=>$id]);
        }

        return $this->render('product/form.html.twig', [
            'form' => $form->createView(),
            'title' => $title,
        ]);
    }

    public function delete(Request $request, $id){
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        $this->addFlash('success', 'The product has been deleted.');

        return $this->redirectToRoute('product_list');
    }
}