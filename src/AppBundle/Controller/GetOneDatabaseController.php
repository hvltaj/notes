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

class GetOneDatabaseController extends Controller
{
    /**
     * @Route("/getone", name="getone")
     */
    public function createAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Goal');

        $request = Request::createFromGlobals();
        $id = $request->query->get('id');

        $products = $repository->findOneBy(
            array('id' => $id)
        );


        return new Response($products->getDescription());
    }

}