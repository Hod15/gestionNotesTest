<?php

namespace App\Controller;

use App\Entity\ Enseignement;
use App\Form\EnseignementType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EnseignementController extends AbstractController
{

    /**
    * @Route("/siteAdministration/enseignement", name="enseignement")
    * @Route("/siteAdministration/enseignement/{id}", name="modif_enseignement")
    */
    public function index(Request $request,Enseignement $enseignement = null)
    {
        $enseignementRepo = $this->getDoctrine()->getRepository(Enseignement::class);

        if(!$enseignement)
            $enseignement = new Enseignement();
        
        $manager = $this->getDoctrine()->getManager();

        $formEnseignement = $this->createForm(EnseignementType::class, $enseignement);

        $formEnseignement->handleRequest($request);

        if($formEnseignement->isSubmitted() && $formEnseignement->isValid())
        {
            if(!$enseignement->getId())
                $enseignement->setCreatedAt(new \DateTime);

            $enseignement->setModifiedAt(new \DateTime);

            $manager->persist($enseignement);
            $manager->flush();

            return $this->redirectToRoute('enseignement');
        }

        return $this->render('site_administration/enseignement.html.twig',
        [
            'formEnseignement' => $formEnseignement->createView(),
            'enseignements' => $enseignementRepo->findAll(),
            'entity' => 'Enseignement'
        ]);
    }

    /**
     * @Route("/siteAdministration/enseignement/delete/{id}", name="delete_enseignement")
     */
    public function delete(Enseignement $enseignement)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($enseignement);
        $manager->flush();

        return $this->redirectToRoute('enseignement');
    }
}