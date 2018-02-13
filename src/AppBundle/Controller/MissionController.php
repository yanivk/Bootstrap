<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mission;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/mission")
 */
class MissionController extends Controller
{

        /**
         * @Route("/", name="homepage")
         */
        public function indexAction(Request $request)
        {
            // replace this example code with whatever you need
            return $this->render('default/index.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            ]);
        }
        /**
         * @Route("/add", name="add_mission")
         */
        public function addAction(Request $request)
        {

            $mission = new Mission();
            //$task->setTask('Write a blog post');
            //$task->setDueDate(new \DateTime('tomorrow'));

            $form = $this->createForm(\AppBundle\Form\Type\MissionFormType::class, $mission);

       // Si la requête est en POST
       if ($request->isMethod('POST')) {
         // On fait le lien Requête <-> Formulaire
         // À partir de maintenant, la variable $form contient les valeurs entrées dans le formulaire par le visiteur
         $form->handleRequest($request);
         // On vérifie que les valeurs entrées sont correctes
         if ($form->isSubmitted() && $form->isValid()) {
           // On enregistre notre objet $form dans la base de données.

           $em = $this->getDoctrine()->getManager();
           $em->persist($mission);
           $em->flush();
           $request->getSession()->getFlashBag()->add('notice', 'Entreprise bien enregistrée.');
           return $this->render('Mission/mission.html.twig', array(
             'form' => $form->createView(),
           ));
         }

       }
       return $this->render('Mission/mission.html.twig', array(
         'form' => $form->createView(),
       ));
       }

}
