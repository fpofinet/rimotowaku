<?php

namespace App\Controller;

use App\Entity\Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SendController extends AbstractController
{
    /**
     * @Route("/send", name="send")
     */
    public function index(Request $request): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $logged_user= $this->getUser();
        if($request->isXmlHttpRequest()){
            var_dump('success');
            $message = new Message();
            $message->setReceiver($request->request->get('receiver'));
            $message->setCreatedAt(new \DateTime());
            $message->setSender($logged_user);
            $message->setContent($request->request->get('contenue'));
            $manager->persist( $message);
            $manager->flush();
            return new JsonResponse(["binks" =>"cest doux"]);
        }
        return $this->render('send/discussion.html.twig');
    }
}
