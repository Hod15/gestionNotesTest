<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Module;
use App\Form\UserType;
use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EtudiantController extends AbstractController
{
    /**
     * @Route("/siteAdministration/etudiant", name="etudiant")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Etudiant::class);
        return $this->render("site_administration/etudiant.html.twig",
        [
            'entity' => "Etudiant",
            'etudiants' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/siteAdministration/createEtudiant", name="create_etudiant")
     */
    public function create(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $etudiant = new Etudiant();
        $manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(UserType::class,$user);
        $radio = $this->createForm(EtudiantType::class,$etudiant);

        $radio->handleRequest($request);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() && $radio->isValid())
        {
            $user->setCreatedAt(new \DateTime);
            $user->setModifiedAt(new \DateTime);
            $user->setPassword($encoder->encodePassword($user,"undefined"));

            $roles = array("ROLE_USER",'ROLE_ETUDIANT');
            $user->setRoles($roles);
            $user->setEnable(false);

            $etudiant->setUser($user);

            $manager->persist($user);
            $manager->persist($etudiant);
            $manager->flush();

            return $this->redirectToRoute("etudiant");
        }

        return $this->render("site_administration/etudiantCreate.html.twig",
        [
            'entity' => "Etudiant",
            'form' => $form->createView(),
            'radio' => $radio->createView(),
        ]);
    }

    /**
     * @Route("/siteAdministration/etudiant/delete/{id}", name="delete_etudiant")
     */
    public function delete(Etudiant $etudiant)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($etudiant);
        $manager->flush();

        return $this->redirectToRoute('etudiant');
    }
}