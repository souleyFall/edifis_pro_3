<?php

namespace App\Controller;

use App\Entity\Affectation;
use App\Entity\Chantier;
use App\Entity\Prestataire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PrestataireController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function account(EntityManagerInterface $em): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $user=$em->getRepository(Prestataire::class)->findBy(['id' => $this->getUser()->getId()])[0];
        $affectation = $user->getAffectation();
        $chantier=null;
        if($affectation){
            $chantier=$affectation->getChantier();
        }
        return $this->render('account/index.html.twig', [
            'user' => $user,
            'chantier' => $chantier,
        ]);
    }

    #[Route('/test', name: 'app_test')]
    public function test(EntityManagerInterface $em): Response
    {
        $users=$em->getRepository(Prestataire::class)->findAll();
        $affectations = $em->getRepository(Affectation::class)->findAll();
        $chantiers=$em->getRepository(Chantier::class)->findAll();
        return $this->render('test/index.html.twig', [
            'users' => $users,
            'chantiers' => $chantiers,
            'affections' => $affectations,
        ]);
    }
}
