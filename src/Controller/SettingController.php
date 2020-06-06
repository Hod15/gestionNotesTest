<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SettingController extends AbstractController
{
    /**
     * @Route("/setting", name="setting")
     */
    public function index(UserInterface $user,Request $request,UserPasswordEncoderInterface $encoder)
    {

        $user->setPassword(' ');
        $form = $this->createForm(UserType::class,$user);
        
        $form->add('password',PasswordType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $user->setModifiedAt(new \DateTime());

            $this->getDoctrine()->getManager()
                ->persist($user)
                ->flush();
        }
        return $this->render('setting/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
