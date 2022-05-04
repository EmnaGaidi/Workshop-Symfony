<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first/{name?user}', name: 'app_first')]
    public function first($name): Response
    {
        return $this->render('first/index.html.twig',[
            'name'=>$name
        ]);
    }

    #[Route('/second',name: 'second.action')]
    public function second(Request $request):Response
    {
        dd($request);
        return $this->render('first/index.html.twig');
    }
}
