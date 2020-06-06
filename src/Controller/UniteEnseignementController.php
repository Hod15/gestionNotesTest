<?php

namespace App\Controller;

use App\Entity\UniteEnseignement;
use App\Form\UniteEnseignementType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UniteEnseignementController extends AbstractController
{
    /**
     * @Route("/siteAdministration/unite_enseignement", name="uniteEnseignement")
     * @Route("/siteAdministration/unite_enseignement/{id}", name="modif_uniteEnseignement")
     */

    public function index(Request $request, UniteEnseignement $uniteEns = null)
    {
        if(!$uniteEns)
            $uniteEns = new UniteEnseignement();

        $uniteEnseignementRepo = $this->getDoctrine()->getRepository(UniteEnseignement::class);

        $formUnite = $this->createForm(UniteEnseignementType::class,$uniteEns);
        
        $manager = $this->getDoctrine()->getManager();

        $formUnite->handleRequest($request);

        if($formUnite->isSubmitted() && $formUnite->isValid())
        {
            if(!$uniteEns->getId())
                $uniteEns->setCreatedAt(new \DateTime);
            $uniteEns->setModifiedAt(new \DateTime);

            $manager->persist($uniteEns);
            $manager->flush();

            return $this->redirectToRoute('uniteEnseignement');
        }
        
        return $this->render('site_administration/uniteEnseignement.html.twig',
        [
            'entity' => "Unite d'Enseignement",
            'uniteEnseignements' => $uniteEnseignementRepo->findAll(),
            'formUnite' => $formUnite->createView(),
        ]);
    }

    /**
     * @Route("/siteAdministration/unite_enseignement/delete/{id}", name="delete_uniteEnseignement")
     */
    public function delete(UniteEnseignement $uniteEnseignement)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($uniteEnseignement);
        $manager->flush();

        return $this->redirectToRoute('uniteEnseignement');
    }

}