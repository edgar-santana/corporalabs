<?php

namespace App\Controller;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\ClientType;

class ClientController extends AbstractController{
    
    public function new(Request $request){
        $client = new Client();

        $form = $this->createForm(ClientType::class, $client);
        $title = "New Client";

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            $this->addFlash('success', 'The client has been created.');

            return $this->redirectToRoute('client_new');
        }

        return $this->render('client/form.html.twig', [
            'form' => $form->createView(),
            'title' => $title,
        ]);
    }

    public function list(){
        $clients = $this->getDoctrine()
            ->getRepository(Client::class)
            ->findAll();
        
        return $this->render('client/list.html.twig', [
            'clients' => $clients,
        ]);
    }

    public function edit(Request $request, $id){
        $client = $this->getDoctrine()
            ->getRepository(Client::class)
            ->find($id);

        $form = $this->createForm(ClientType::class, $client);
        $title = "Edit Client: ".$client->getName();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            $this->addFlash('success', 'The client has been changed.');

            return $this->redirectToRoute('client_edit',["id"=>$id]);
        }

        return $this->render('client/form.html.twig', [
            'form' => $form->createView(),
            'title' => $title,
        ]);
    }

    public function delete(Request $request, $id){
        $client = $this->getDoctrine()
            ->getRepository(Client::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($client);
        $em->flush();

        $this->addFlash('success', 'The client has been deleted.');

        return $this->redirectToRoute('client_list');
    }
}