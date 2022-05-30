<?php

namespace App\Controller;

use App\Classe\Search;
use App\Form\SearchType;
use App\Repository\CalendarRepository;
use App\Repository\CategorieRepository;
use App\Repository\PartenaireRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Services\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("admin/agenda",name="agenda")
     * @param CalendarRepository $repository
     * @param NormalizerInterface $normalizer
     * @return Response
     */
    public function calendar(CalendarRepository $repository,NormalizerInterface $normalizer)
    {
      $ligne = $repository->findAll();
      $rdvs = [];

      foreach ($ligne as $data){
          $rdvs [] = [
              'id'=>$data->getId(),
              'start'=>$data->getStart()->format('Y-m-d H:i:s'),
              'end'=>$data->getEnd()->format('Y-m-d H:i:s'),
              'description'=>$data->getDescription(),
              'title'=>$data->getTitle(),
              'allDay'=>$data->getAllDay(),
              'backgroundColor'=>$data->getBackgroundColor(),
              'borderColor'=>$data->getBorderColor(),
              'textColor'=>$data->getTextColor(),
          ];
      }

      $data =  json_encode($rdvs);
      //dd($data);

        return $this->render("calendar/calendar.html.twig",compact('data'));
    }

    /**
     * @Route("/admin/dashboard", name="dashboard", methods={"GET", "POST"})
     * @return Response
     */
    public function dashboard()
    {
        return $this->render('_admin/dashboard/index.html.twig');
    }

    /**
     * @Route("/admin/frais", name="frais", methods={"GET", "POST"})
     * @return Response
     */
    public function frais()
    {
        return $this->render('_admin/frais/index.html.twig');
    }

    /**
     * @Route("/", name="home", methods={"GET", "POST"})
     * @param CategorieRepository $categorieRepository
     * @return Response
     */
    public function enig(CategorieRepository $categorieRepository)
    {
        $data = $categorieRepository->listeCategorie();
        return $this->render('fils/home.html.twig', [
            'pagination' => $data
        ]);
    }
    /**
     * @Route("/about", name="about", methods={"GET", "POST"})
     * @param PartenaireRepository $partenaireRepository
     * @return Response
     */
    public function about(PartenaireRepository $partenaireRepository)
    {
        return $this->render('fils/about.html.twig',[
            'listePartenaires'=>$partenaireRepository->findAll()
        ]);
    }
    /**
     * @param $id
     * @param ProduitRepository $produitRepository
     * @return Response
     */
    public function afficheProduitCategorie($id, ProduitRepository $produitRepository): Response
    {
        $data = $produitRepository->affiche_produit_all($id);
        return $this->render('fils/affiche_produit_dune_categorie.html.twig', [
            'data' => $data
        ]);
    }

    /**
     * @Route("/affiche_produit/{id}", name="one_produit", methods={"GET", "POST"})
     * @param $id
     * @param ProduitRepository $produitRepository
     * @return Response
     */
    public function afficheProduit($id, ProduitRepository $produitRepository): Response
    {
        $data = $produitRepository->find($id);
//dd($data);

        return $this->render('fils/affiche_un_produit.html.twig', [
            'data' => $data
        ]);
    }


    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {


        return $this->render('fils/contact.html.twig', [

        ]);
    }





}
