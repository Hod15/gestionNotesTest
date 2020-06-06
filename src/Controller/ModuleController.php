<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
     /**
     * @Route("/siteAdministration/module", name="module")
     * @Route("/siteAdministration/module/{id}", name="modif_module")
     */
    public function index(Request $request,Module $module = null)
    {
        $moduleRepo = $this->getDoctrine()->getRepository(Module::class);

        if(!$module)
            $module = new Module();
        
        $manager = $this->getDoctrine()->getManager();

        $formModule = $this->createForm(ModuleType::class, $module);

        $formModule->handleRequest($request);

        if($formModule->isSubmitted() && $formModule->isValid())
        {
            if(!$module->getId())
                $module->setCreatedAt(new \DateTime);

            $module->setModifiedAt(new \DateTime);

            $manager->persist($module);
            $manager->flush();

            return $this->redirectToRoute('module');
        }

        return $this->render('site_administration/module.html.twig',
        [
            'formModule' => $formModule->createView(),
            'modules' => $moduleRepo->findAll(),
            'entity' => 'Module'
        ]);
    }

    /**
     * @Route("/siteAdministration/module/delete/{id}", name="delete_module")
     */
    public function delete(Module $module)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($module);
        $manager->flush();

        return $this->redirectToRoute('module');
    }
}