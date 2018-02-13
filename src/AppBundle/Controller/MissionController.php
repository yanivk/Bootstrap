<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MissionController extends Controller
{


    $company = new Company();

        // On crée le FormBuilder grâce au service form factory
        // On ajoute les champs de l'entité que l'on veut à notre formulaire
        $form = $this->createForm(\AppBundle\Form\Type\CompanyFormType::class, $company);

        // Si la requête est en POST
        if ($request->isMethod('POST')) {
          // On fait le lien Requête <-> Formulaire
          // À partir de maintenant, la variable $form contient les valeurs entrées dans le formulaire par le visiteur
          $form->handleRequest($request);
          // On vérifie que les valeurs entrées sont correctes
          if ($form->isSubmitted() && $form->isValid()) {
            // On enregistre notre objet $form dans la base de données.

            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Entreprise bien enregistrée.');
            // On redirige vers la page de visualisation de l'entreprise nouvellement créée
            return $this->redirectToRoute('iris_company_fiche', array('id' => $company->getId()));
          }
        }

        // À partir du formBuilder, on génère le formulaire

        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('IrisCompanyBundle:Default:creationEntreprise.html.twig', array(
          'form' => $form->createView(),
        ));
        }

}
