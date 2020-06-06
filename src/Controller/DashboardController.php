<?php

namespace App\Controller;

use App\Entity\Module;
use App\Entity\Controle;
use App\Entity\Etudiant;
use App\Entity\Enseignant;
use App\Entity\RegroupementModule;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Promotion;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(UserInterface $user)
    {
        if(in_array("ROLE_ETUDIANT", $user->getRoles()))
        {
            $etudiant = $this->getDoctrine()->getRepository(Etudiant::class)->findOneByUser($user);
        

            $uniteEnseignements = $this->getDoctrine()->getRepository(RegroupementModule::class)->findByPromotion($etudiant->getPromotion());

            $etudiants = $this->getDoctrine()->getRepository(Promotion::class)->find($etudiant->getPromotion())->getEtudiants();

            return $this->render('dashboard/index.html.twig', [
                'data' => $uniteEnseignements,
            ]);
        }

        else if(in_array("ROLE_ENSEIGNANT", $user->getRoles()))
        {
            $enseignant = $this->getDoctrine()->getRepository(Enseignant::class)->findOneByUser($user);

            $modules = $enseignant->getModules();

            $data = array();

            /*foreach($modules as $module)
            {
                $controles = $this->getDoctrine()->getRepository(Controle::class)->findByModule($module);
                
                if($controles)
                {
                    $etudiants = $controles[0]->getEtudiants();

                    $notes = array();

                    foreach($etudiants as $etudiant)
                    {
                        $lines = array();

                        $lines->append($etudiant);

                        $controles_note = array();

                        foreach($controles as $controle)
                        {
                            $append = $this->getDoctrine()->getRepository(Note::class)->findBy(array('controle' => $controle, 'etudiant' => $etudiant));
                            $controles_note->append($append);
                        }

                        $lines->append($controles_note);

                        $notes->append($lines);
                    }
                }

                else
                {
                    $notes = NULL;
                }

                $data->append($notes);
            }*/

            return $this->render('dashboard/index.html.twig', [
                'data' => "",
            ]);
        }

        return $this->render('dashboard/index.html.twig', [
            'data' => "",
        ]);
    }
    
    /**
     * @Route("dashboard/module{id}/notes/", name="module_notes")
     */
    public function notesView(Module $module)
    {
        $controles = $this->getDoctrine()->getRepository(Controle::class)->findByModule($module);
        
        if($controles)
        {
            /*$etudiants = $controles[0]->getEtudiants();

            $notes = array();

            foreach($etudiants as $etudiant)
            {
                $controles_note = array();

                foreach($controles as $controle)
                {
                    $append = $this->getDoctrine()->getRepository(Note::class)->findOneBy(['controle' => $controle], ['etudiant' => $etudiant]);
                    $controles_note->append($append);
                }

                $notes->append($controles_note);
            }*/
        }

        else
        {
            $notes = NULL;
            $etudiants = NULL;
        }

        return $this->render('dashboard/notesView.html.twig',[
            'etudiants' => $etudiants,
            'notes' => $notes,
        ]);
    }
}
