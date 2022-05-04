<?php

namespace App\Controller;

use App\Entity\Formation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{
    #[Route('/active', name: 'formation.active')]
    public function activeFormation(EntityManagerInterface $doctrine): Response
    {
        $repository = $doctrine->getRepository(Formation::class);
        $formations = $repository->selectActive();
        return $this->render('formation/active.html.twig', [
            'formations' => $formations
        ]);
    }
}
