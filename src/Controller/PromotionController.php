<?php

namespace App\Controller;

use App\Entity\Promotion;
use App\Form\PromotionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PromotionController extends AbstractController
{

    /**
    * @Route("/siteAdministration/promotion", name="promotion")
    * @Route("/siteAdministration/promotion/{id}", name="modif_promotion")
    */

    public function index(Request $request,Promotion $promotion = null)
    {
        $promotionRepo = $this->getDoctrine()->getRepository(Promotion::class);

        if(!$promotion)
            $promotion = new Promotion();
        
        $manager = $this->getDoctrine()->getManager();

        $formProm = $this->createForm(PromotionType::class, $promotion);

        $formProm->handleRequest($request);

        if($formProm->isSubmitted() && $formProm->isValid())
        {
            if(!$promotion->getId())
                $promotion->setCreatedAt(new \DateTime);

            $promotion->setModifiedAt(new \DateTime);

            $manager->persist($promotion);
            $manager->flush();

            return $this->redirectToRoute('promotion');
        }

        return $this->render('site_administration/promotion.html.twig',
        [
            'formProm' => $formProm->createView(),
            'promotions' => $promotionRepo->findAll(),
            'entity' => 'Promotion'
        ]);
    }

    /**
     * @Route("/siteAdministration/promotion/delete/{id}", name="delete_promotion")
     */
    public function delete(Promotion $promotion)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($promotion);
        $manager->flush();

        return $this->redirectToRoute('promotion');
    }
}