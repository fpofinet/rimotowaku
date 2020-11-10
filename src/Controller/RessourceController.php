<?php

namespace App\Controller;

use App\Entity\Ressource;
use App\Entity\Utilisateurs;
use App\Form\RessourceType;
use App\Repository\UtilisateursRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class RessourceController extends AbstractController
{
    /**
     * @Route("/ressource", name="ressource")
     */
    public function index(): Response
    {
        return $this->render('ressource/index.html.twig', [
            'controller_name' => 'RessourceController',
        ]);
    }
    /**
     * @Route("/fichier", name="fichier")
     */
    public function addRessource(Ressource $ressource=null,Request $request,SluggerInterface $slugger){
        $manager = $this->getDoctrine()->getManager();
        if(!$ressource){
            $ressource = new Ressource();
        }
        //creation de formulaire d'ajout et maj de ressources
        $formRessource= $this->createForm(RessourceType::class,$ressource);
        $formRessource->handleRequest( $request);

        //validation du formulaire
        if( $formRessource->isSubmitted() &&  $formRessource->isValid()){
            $fichier = $formRessource->get('chemin')->getData();
            if ($fichier) {
                $originalFilename = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$fichier->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $fichier->move(
                        $this->getParameter('fichier_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'profilname' property to store the PDF file name
                // instead of its contents
                $ressource->setChemin($newFilename);
            }

            if(!$ressource->getId()){
                $repo = $this->getDoctrine()->getRepository(Utilisateurs::class);
                $auteur=$repo->findOneBy(['nom' => 'barna']);


                $ressource->setCreatedAt(new \DateTime());
                $ressource->setAuteur($auteur);
            }
           
            $manager->persist( $ressource);
            $manager->flush();
             
            return $this->redirectToRoute('home');
        }
        return $this->render('ressource/index.html.twig',[
            'formres' => $formRessource->createView(),
            'editState' => $ressource->getId() !==null
            ]);
       

    }
}
