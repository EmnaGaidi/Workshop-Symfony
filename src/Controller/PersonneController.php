<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/personne')]
class PersonneController extends AbstractController
{
    #[Route('/add/{name}/{firstname}/{age}/{cin}/{path?none}', name: 'personne.add')]
    public function add($name,$firstname,$age,$cin,$path,ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $personne = new Personne();
        $personne->setNom($name);
        $personne->setPrenom($firstname);
        $personne->setAge($age);
        if ($cin){
            $personne->setCin($cin);
        }
        if ($path){
            $personne->setPath($path);
        }
        $entityManager->persist($personne);
        $entityManager->flush();
        $this->addFlash('success', 'la nouvelle personne a été ajoutée avec succès');
        return $this->render('personne/index.html.twig', [
            'personne' => $personne,
        ]);
    }

    #[Route('/edit/{id}/{name}/{firstname}/{age?}/{cin?}/{path?none}', name: 'personne.edit')]
    public function edit($name,$firstname,$age,$cin,$path,ManagerRegistry $doctrine,Personne $personne = null)
    {
        if (!$personne){
            $this->addFlash('error','cette personne n exite pas');
        }else{
            $personne->setNom($name);
            $personne->setPrenom($firstname);
            $personne->setAge($age);
            $personne->setCin($cin);
            $personne->setPath($path);
            $manager = $doctrine->getManager();
            $manager->persist($personne);
            $manager->flush();
            $this->addFlash('success','edit effectué');
    }
      return  $this->redirectToRoute('personne.showAll');
    }

    #[Route('/show/{page?1}/{nbre?3}',name: 'personne.showAll')]
    public function showAll(ManagerRegistry $doctrine, $page, $nbre):Response
    {
        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->findBy([],[],$nbre,($page-1)*$nbre);
        $personnestotal = $repository->findAll();
        $maxPage = ceil(count($personnestotal)/$nbre);
        return $this->render('personne/showAll.html.twig',[
            'personnes'=>$personnes,
            'page'=>$page,
            'nbre'=>$nbre,
            'maxPage'=>$maxPage
        ]);
    }

    #[Route('/delete/{id}',name: 'personne.delete')]
    public function delete(Personne $personne=null, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        if($personne){
            $entityManager->remove($personne);
            $entityManager->flush();
            $this->addFlash('success','la personne a été supprimer');
        }else{
            $this->addFlash('error','cette personne n existe pas');
        }
        return $this->redirectToRoute('personne.showAll');
    }

    #[Route('/profil/{id}',name: 'personne.profil')]
    public function profil(Personne $personne = null,ManagerRegistry $doctrine):Response
    {
        $entityManager = $doctrine->getRepository(Personne::class);
        if (!$personne){
            $this->addFlash('error','cette personne n existe pas');
        return    $this->redirectToRoute('personne.showAll');}

        return $this->render('personne/profil.html.twig',[
            'personne'=>$personne
        ]);
    }

    #[Route('/trie/{name}',name: 'personne.trie')]
    public function trieByName($name,ManagerRegistry $doctrine ):Response{
        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->findBy(array('nom'=>$name),array('prenom'=>'ASC'),5);
        return $this->render('personne/trie.html.twig',[
           'personnes'=>$personnes
        ]);
    }

    #[Route('/trieAge/{age}',name: 'personne.trieAge')]
    public function trieByAge($age, ManagerRegistry $doctrine):Response{
        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->selectByAge($age);
        return $this->render('personne/trieAge.html.twig',[
           'personnes'=>$personnes,
            'ageMax'=>$age
        ]);
    }
    #[Route('/addMe',name: 'personne.form')]
    public function addMe(ManagerRegistry $doctrine, \Symfony\Component\HttpFoundation\Request $request):Response{
        $entityManager  = $doctrine->getManager();
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);
        $form->remove('created_at');
        $form->remove('update_at');
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $entityManager->persist($personne);
            $entityManager->flush();
            $this->addFlash('success','la personne est ajoutée avec succès');
            return $this->redirectToRoute('personne.showAll');
        }else{
        return $this->render('personne/form.html.twig',[
            'form'=>$form->createView()
        ]);}
    }
}
