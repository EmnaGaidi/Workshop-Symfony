<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CvController extends AbstractController
{
    #[Route('/cv/{name}/{firstname}/{age<[0,9]?\d{1}>}/{section<GL|RT>}/{langue<fr|ang>}', name: 'app_cv' )]
    public function index($name,$firstname,$age,$section,$langue): Response
    {
        return $this->render('cv/index.html.twig', [
            'name'=>$name,
            'firstname'=>$firstname,
            'age'=>$age,
            'section'=>$section,
            'langue'=>$langue
        ]);
    }
}
