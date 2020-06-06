<?php

namespace App\Controller;

use App\Entity\Module;
use App\Entity\Controle;
use App\Entity\Etudiant;
use App\Entity\Promotion;
use App\Entity\Enseignant;
use App\Entity\Departement;
use App\Entity\Enseignement;
use App\Entity\UniteEnseignement;
use App\Entity\RegroupementModule;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SiteAdministrationController extends AbstractController
{
    
    /**
     * @Route("/siteAdministration", name="site_administration")
     */
    public function index()
    {
        //repositorys
        $departementRepo = $this->getDoctrine()->getRepository(Departement::class);
        $promotionRepo = $this->getDoctrine()->getRepository(Promotion::class);
        $moduleRepo = $this->getDoctrine()->getRepository(Module::class);
        $enseignementRepo = $this->getDoctrine()->getRepository(Enseignement::class);
        $uniteEnseignementRepo = $this->getDoctrine()->getRepository(UniteEnseignement::class);
        $enseignantRepo = $this->getDoctrine()->getRepository(Enseignant::class);
        $etudiantRepo = $this->getDoctrine()->getRepository(Etudiant::class);
        $controleRepo = $this->getDoctrine()->getRepository(Controle::class);
        $regroupementModuleRepo = $this->getDoctrine()->getRepository(RegroupementModule::class);

        return $this->render('site_administration/index.html.twig', [
            'nb_departement' => $departementRepo->findAll(),
            'nb_promotion' => $promotionRepo->findAll(),
            'nb_module' => $moduleRepo->findAll(),
            'nb_enseignement' => $enseignementRepo->findAll(),
            'nb_uniteEnseignement' => $uniteEnseignementRepo->findAll(),
            'nb_enseignant' => $enseignantRepo->findAll(),
            'nb_etudiant' => $etudiantRepo->findAll(),
            'nb_controle' => $controleRepo->findAll(),
            'nb_regroupementModule' => $regroupementModuleRepo->findAll(),
            'controller_name' => 'SiteAdministrationController',
        ]);
    }

}
