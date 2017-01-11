<?php
/**
 * Created by PhpStorm.
 * User: pawel
 * Date: 10.01.17
 * Time: 11:34
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Goal;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;

class SaveDatabaseController extends Controller
{
    /**
     * @Route("/save", name="save")
     */
    public function createAction(Request $request)
    {
        $product = new Goal();

        $request = Request::createFromGlobals();
        $desc = $request->query->get('description');
        $priority = $request->query->get('priority');

        $name = $this->get('security.token_storage')->getToken()->getUser()->getUsername();

        $product->setUsername($name);
        $product->setProgress(0);
        $product->setDescription($desc);
        $product->setPriority((int)$priority);
        $product->setDate(new \DateTime("now"));


        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return $this->render('todo/single.html.twig', [
            'item' => $product,
        ]);
    }

}