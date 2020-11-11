<?php

namespace App\Controller;


use App\Entity\Utilisateurs;
use App\Form\InscriptionType;
use Doctrine\Persistence\ObjectManager;
//use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur", name="user")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Utilisateurs::class);
        $listeUtilisateur= $repo->findAll();
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs'  => $listeUtilisateur
        ]);
    }
    /**
     *
     */
    public function home(){
       // return $this->render('utilisateur/home.html.twig');
    }
        // cette methode permet d'ajouter ou de modifier un utilisateur
    /**
     * @Route("/admin/nouvelUtilisateur", name="add_user")
     * @Route("/admin/{id}/modification", name="edit_user")
     */
    public function addOrUpdateUtilisateur(Utilisateurs $user=null,Request $request,UserPasswordEncoderInterface $encoder,
                                            SluggerInterface $slugger)
    {
        $manager = $this->getDoctrine()->getManager();
        if(!$user){
            $user = new Utilisateurs();
        }
        //creation de formulaire d'ajout et maj utilisateurs
        $form= $this->createForm(InscriptionType::class,$user);
        $form->handleRequest( $request);
        //validation du formulaire
        if( $form->isSubmitted() &&  $form->isValid()){
            $profil = $form->get('profil')->getData();
            if ($profil) {
                $originalFilename = pathinfo($profil->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$profil->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $profil->move(
                        $this->getParameter('profil_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'profilname' property to store the PDF file name
                // instead of its contents
                $user->setProfil($newFilename);
            }

            if(!$user->getId()){
                $user->setCreatedAtU(new \DateTime());
            }

            $hash= $encoder->encodePassword($user,$user->getMotDePasse());
            $user->setMotDePasse($hash);
            $manager->persist( $user);
            $manager->flush();
             
            return $this->redirectToRoute('app_login');
        }

        return $this->render('utilisateur/addUser.html.twig',[
            'formUser' => $form->createView(),
            'editState' => $user->getId() !==null
        ]);
    }
    // cette methode permet d'afficher un utilisateur par son id

    /**
     * @Route("/utilisateur/{id}", name="show_user")
     */
    public function showOne($id){
        $repo = $this->getDoctrine()->getRepository(Utilisateurs::class);
        $utilisateur= $repo->find($id);
        return $this->render('./utilisateur/show.html.twig',[
            'utilisateur' => $utilisateur
        ]);
    }
    // cette  methode permet au utilisateurs de se connecter
    /**
     * @Route("/connexion",name="login_route")
     */
    public function login(){
        return $this->render('utilisateur/login.html.twig');
    }
    
}
