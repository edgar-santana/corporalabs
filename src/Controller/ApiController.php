<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\ClientOrder;
use App\Entity\Product;
use App\Entity\Client;
use App\Entity\OrdersProducts;
/**
 * Api controller.
 */
class ApiController extends FOSRestController
{
    /**
     * Lists all Clients.
     *
     * @return Response
     */
    public function getClients(){
        $clients = $this->getDoctrine()->getRepository(Client::class)->findAllApi();
        return $this->handleView($this->view($clients));
    }
    /**
     * Lists all Products.
     *
     * @return Response
     */
    public function getProducts(){
        $products = $this->getDoctrine()->getRepository(Product::class)->findAllApi();
        return $this->handleView($this->view($products));
    }
    /**
     * Lists all Orders.
     *
     * @return Response
     */
    public function getOrders(){
        $orders = $this->getDoctrine()->getRepository(ClientOrder::class)->findAllApi();
        return $this->handleView($this->view($orders));
    }  
}