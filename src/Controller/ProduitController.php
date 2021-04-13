<?php

namespace App\Controller;

use App\Donnees\DonneesRecherche;
use App\Form\RechercheForm;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="app_produit_index")
     */
    public function index(ProduitRepository$repository, Request $request){
        $donnees= new DonneesRecherche();
        $form= $this->createForm(RechercheForm::class,$donnees);
        $form->handleRequest($request);
        $produits = $repository->findCriteresRecherche($donnees);
        return $this->render('produit/index.html.twig',
            ['produits' => $produits,
                'form' => $form->createView()
            ]);
    }
}
