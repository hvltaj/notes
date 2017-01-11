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

class RenderDatabaseController extends Controller
{
    /**
     * @Route("/render", name="render")
     */
    public function createAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Goal');

        $products = $repository->findBy(
            array('username' => $this->get('security.token_storage')->getToken()->getUser()->getUsername()),
            array('date' => 'ASC')
        );


        return $this->render('todo/render.html.twig', [
            'products' => $products,
        ]);
    }

}