<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class TestController extends Controller
{
    /**
     * @Route("/test", name="test")
     */
    public function indexAction(Request $request)
    {
        $var = 'zoRRo';
        $user = $this->get('security.token_storage')->getToken()->getUser();

        // replace this example code with whatever you need
        return $this->render('test/test.html.twig', [
            'var' => $user->getUsername(),
        ]);
    }
}