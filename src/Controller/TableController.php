<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TableController extends AbstractController
{
    #[Route('/table/{nb?5}', name: 'app_table')]
    public function note($nb): Response
    {
        $path = '';
        $table = [];
        for ($i=0;$i<$nb;$i++){
            $table[]=rand();
        }
        return $this->render('table/index.html.twig',[
            'table'=>$table,
            'path'=>$path
        ]);
    }
}
