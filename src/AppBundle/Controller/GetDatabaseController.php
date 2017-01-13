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

class GetDatabaseController extends Controller
{
    /**
     * @Route("/todo", name="todo")
     */
    public function createAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Goal');

        $products = $repository->findBy(
            array('username' => $this->get('security.token_storage')->getToken()->getUser()->getUsername()),
            array('priority' => 'DESC')
        );

        $today_stat = 0;
        $week_stat = 0;


        $goals = Array();
        $done_goals = Array();

        $today_done = 0;
        $today_not_done = 0;

        $week_done = 0;
        $week_not_done = 0;

        $today = new \DateTime("now");
        $date_7days_ago = $today->sub(new \DateInterval('P7D'));
        $today = new \DateTime("now");
        $one_day = $today->sub(new \DateInterval('P1D'));
        $today = new \DateTime("now");

        foreach ($products as $item){

            if ($item->getProgress() == 0) {
                $goals[] = $item;
            } else {
                $done_goals[] = $item;
            }

            if ($item->getDate() > $one_day){
                if ($item->getProgress() == 0){
                    $today_not_done += 1;
                } else {
                    $today_done += 1;
                }
            }

            if ($item->getDate() > $date_7days_ago and $item->getDate() < $today) {
                if ($item->getProgress() == 0){
                    $week_not_done += 1;
                } else {
                    $week_done += 1;
                }
            }

        }

        if ($today_done == 0){
            $today_done = 1;
        }
        if ($week_done == 0){
            $week_done = 1;
        }

        $today_stat = round($today_done / ($today_not_done + $today_done), 2) * 100;
        $week_stat = round($week_done / ($week_done + $week_not_done), 2) * 100;

        return $this->render('todo/todo.html.twig', [
            'products' => $goals,
            'today_stat' => (string)$today_stat,
            'week_stat' => (string)$week_stat,
            'done_goals' => $done_goals,
        ]);
    }

}