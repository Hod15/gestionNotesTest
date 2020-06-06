<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ControlesController extends AbstractController
{
    /**
     * @Route("/controles", name="controles")
     */
    public function index(UserInterface $user)
    {
        $user->getUsername();
        return $this->render('controles/index.html.twig', [
            'entity' => 'Controles',
        ]);
    }
}
