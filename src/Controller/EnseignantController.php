<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Enseignant;
use App\Entity\Module;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EnseignantController extends AbstractController
{

    /**
     * @Route("/siteAdministration/enseignant", name="enseignant")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Enseignant::class);
        return $this->render("site_administration/enseignant.html.twig",
        [
            'entity' => "Enseignant",
            'enseignants' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/siteAdministration/createEnseignant", name="create_enseignant")
     */
    public function create(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $enseignant = new Enseignant();
        $manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $user->setCreatedAt(new \DateTime);
            $user->setModifiedAt(new \DateTime);
            $user->setPassword($encoder->encodePassword($user,"undefined"));

            $roles = array('ROLE_ENSEIGNANT');
            $user->setRoles($roles);
            $user->setEnable(false);

            $enseignant->setUser($user);

            $manager->persist($user);
            $manager->persist($enseignant);
            $manager->flush();

            return $this->redirectToRoute("enseignant");
        }

        return $this->render("site_administration/enseignantCreate.html.twig",
        [
            'entity' => "Enseignant",
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/siteAdministration/enseignant/delete/{id}", name="delete_enseignant")
     */
    public function delete(Enseignant $enseignant)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($enseignant);
        $manager->flush();

        return $this->redirectToRoute('enseignant');
    }
    /*
    /**
     * @Route("/siteAdministration/affecter/{id}", name="affecter_enseignant")
     

    public function affecter(Enseignant $enseignant,Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $formAffect = $this->createForm(EnseignantType::class,$enseignant);

        $formAffect->handleRequest($request);

        if($formAffect->isSubmitted() && $formAffect->isValid())
        {
            $manager->persist($enseignant);

            foreach($enseignant->getModules() as $module)
            {
                $module->setEnseignant($enseignant);
            }

            $manager->flush();

            return $this->redirectToRoute("enseignant");
        }

        return $this->render("site_administration/affecterEnseignant.html.twig",
            [
                'entity' => "Enseignant",
                "form" => $formAffect->createView(),
                "enseignant" => $enseignant->getUser(),
            ]);
    }*/
}