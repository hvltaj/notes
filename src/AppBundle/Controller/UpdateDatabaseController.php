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

class UpdateDatabaseController extends Controller
{
    /**
     * @Route("/update", name="update")
     */
    public function createAction(Request $request)
    {

        //retrieve goal id

        $repository = $this->getDoctrine()->getRepository('AppBundle:Goal');

        $request = Request::createFromGlobals();
        $id = $request->query->get('id');

        $product = $repository->findOneBy(
            array('id' => (int)$id)
        );

        $product->setProgress(100);

        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return new Response(0);
    }

}