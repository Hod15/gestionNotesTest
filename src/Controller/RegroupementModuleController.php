<?php

namespace App\Controller;

use App\Entity\RegroupementModule;
use App\Form\RegroupementModuleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegroupementModuleController extends AbstractController
{
    /**
     * @Route("/siteAdministration/regroupement_module", name="regroupementModule")
     * @Route("/siteAdministration/regroupement_module/{id}", name="modif_regroupementModule")
     */

    public function regroupementModule(Request $request, RegroupementModule $regroupMod = null)
    {
        if(!$regroupMod)
            $regroupMod = new RegroupementModule();

        $regroupementModuleRepo = $this->getDoctrine()->getRepository(RegroupementModule::class);

        $formRegroup = $this->createForm(RegroupementModuleType::class,$regroupMod);
        
        $manager = $this->getDoctrine()->getManager();

        $formRegroup->handleRequest($request);

        if($formRegroup->isSubmitted() && $formRegroup->isValid())
        {
            if(!$regroupMod->getId())
                $regroupMod->setCreatedAt(new \DateTime);
            $regroupMod->setModifiedAt(new \DateTime);

            $manager->persist($regroupMod);
            $manager->flush();

            return $this->redirectToRoute('regroupementModule');
        }
        
        return $this->render('site_administration/regroupementModule.html.twig',
        [
            'entity' => "Regroupement de Module",
            'regroupementModules' => $regroupementModuleRepo->findAll(),
            'formRegroup' => $formRegroup->createView(),
        ]);
    }

    /**
     * @Route("/siteAdministration/regroupement_module/delete/{id}", name="delete_regroupementModule")
     */
    public function delete(RegroupementModule $RegroupementModule)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($RegroupementModule);
        $manager->flush();

        return $this->redirectToRoute('regroupementModule');
    }
}