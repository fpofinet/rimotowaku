<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Utilisateurs;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class MessageController extends AbstractController
{
    /**
     * @Route("/getmess", name="messages")
     */
    public function getMessages(Request $request)
    {
        if ($request->isXmlHttpRequest()){
            $repo = $this->getDoctrine()->getRepository(Message::class);
            $messages= $repo->findAll();
            $data = array(); 
            foreach ($messages as $item) { 
                $i = array(
                "id" => $item->getId(),
                "sender" => $item->getSender()->getId(), 
                "receiver" => $item->getReceiver(), 
                "content" => $item->getContent(), 
                "date" => $item->getCreatedAt(), 
                ); 

                array_push($data, $i); 
            }
            return new JsonResponse($data);
        }
        return $this->render('message/discussion.html.twig');
    }

    /**
     * @Route("/discussion/{id}", name="discussion")
     */
    public function newMessage($id){
        $repo = $this->getDoctrine()->getRepository(Utilisateurs::class);
        $utilisateur= $repo->find($id);
        return $this->render('message/discussion.html.twig',[
            'receiver' => $utilisateur
        ]);
    }
}
