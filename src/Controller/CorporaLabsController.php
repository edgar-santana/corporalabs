<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Response;

class CorporaLabsController extends AbstractController{
    public function index(){
        $number = random_int(0, 100);

        return $this->render('corporalabs/index.html.twig', [
            'number' => $number,
        ]);
    }
}