<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateurs;
use App\Form\InscriptionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    // cette methode permet d'afficher la liste des utilisateurs
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Utilisateurs::class);
        $listeUtilisateur= $repo->findAll();
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
            'utilisateurs'  => $listeUtilisateur
        ]);
    }   

}
