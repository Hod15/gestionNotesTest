<?php

namespace App\Controller;


use App\Entity\Departement;
use App\Form\DepartementFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DepartementController extends AbstractController
{
    /**
     * @Route("/siteAdministration/departement", name="departement")
     * @Route("/siteAdministration/departement/{id}", name="modif_departement")
     */
    public function index(Departement $departement = null,Request $request)
    {
        $departementRepo = $this->getDoctrine()->getRepository(Departement::class);

        if(!$departement)
            $departement = new Departement();


        $manager = $this->getDoctrine()->getManager();
        $formDepartement = $this->createForm(DepartementFormType::class, $departement);
        
        $formDepartement->handleRequest($request);

        if($formDepartement->isSubmitted() && $formDepartement->isValid())
        {
            if(!$departement->getId())
                $departement->setCreatedAt(new \DateTime());
            
            $departement->setModifiedAt(new \DateTime());

            $manager->persist($departement);
            $manager->flush();
            
            return $this->redirectToRoute('departement');
        }

        return $this->render('site_administration/departement.html.twig',[
            'departements' => $departementRepo->findAll(),
            'formDepartement' => $formDepartement->createView(),
            'entity' => 'Departement'
        ]);
    }

    /**
     * @Route("/siteAdministration/departement/delete/{id}", name="delete_departement")
     */
    public function delete(Departement $departement)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($departement);
        $manager->flush();

        return $this->redirectToRoute('departement');
    }
}