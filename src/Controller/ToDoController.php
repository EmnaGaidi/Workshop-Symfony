<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todo')]
class ToDoController extends AbstractController
{
    #[Route('/', name: 'app_to_do')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        if(!$session->has('todoList')){
            $todoList = ['achat'=>'acheter cle usb',
                'cours'=>'finaliser mon cours',
                'correction'=>'corriger mes examens'];
            $session->set('todoList',$todoList);
            $this->addFlash('info','Le tableau vient d etre initialiser');
        }else{
            $this->addFlash('error','le tableau est déjà initialiser');
        }

        return $this->render('to_do/index.html.twig');
    }
    #[Route('/delete/{cle}',name: 'todo.delete')]
    public function deleteItem($cle, Request $request):Response
    {
        $todoList = $request->getSession()->get('todoList');
        if ($todoList[$cle]){
            unset($todoList[$cle]);
            $request->getSession()->set('todoList',$todoList);
            $this->addFlash('info','la cle a été supprimer');
        }else{
            $this->addFlash('error','la cle n exite pas');
        }
       return $this->redirectToRoute('app_to_do');
    }

    #[Route('/add/{cle}/{valeur}',name: 'todo.add')]
    public function addTodo(Request $request, $cle,$valeur):Response
    {
        $session = $request->getSession();
        if (!$session->get('todoList')){
            $this->addFlash('error','la liste n est pas initialisée');
        }else{
            $todoList = $session->get('todoList');
            $todoList[$cle]=$valeur;
            $session->set('todoList',$todoList);
            $this->addFlash('success','la tache a été bien ajoutée');
        }
     return $this->redirectToRoute('app_to_do');
    }
    #[Route('/reset',name: 'todo.reset')]
    public function reset(Request $request):Response{
        $session = $request->getSession();
        if($session->has('todoList')) {
            $session->remove('todoList');
            $this->addFlash('success', 'le reset a été effectué avec succes');
        }else{
            $this->addFlash('error', 'pas besoin de reset');
        }
        return $this->redirectToRoute('app_to_do');
    }
}
