<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\CourierArrive;
use App\Entity\Fichier;
use App\Form\CourierArriveType;
use App\Repository\ActeRepository;
use App\Repository\CourierArriveRepository;
use App\Repository\DepartementRepository;
use App\Services\PaginationService;
use App\Services\Services;
use App\Services\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin")
 */
class CourierArriveController extends AbstractController
{

    /**
     * @Route("/courrier-arrive", name="courierArrive")
     * @param CourierArriveRepository $repository
     * @return Response
     */
    public function index(CourierArriveRepository $repository): Response
    {

        $pagination = $repository->findBy(['type'=>'ARRIVE','active'=>1]);
        //dd($pagination);
        return $this->render('_admin/arrive/index.html.twig', [
            'pagination' => $pagination,
            'tableau' => [
                'numero' => 'numero',
                'Date_de_réception' => 'Date_de_réception',
                'Objet' => 'Objet',
                'Expediteur' => 'Expediteur',
            ],
            'critereTitre' => '',
            'modal' => 'modal',
            'position' => 4,
            'active' => 7,
            'titre' => 'Liste des courriers arrivés',

        ]);
    }

    /**
     * @Route("/archive/{id}/arrive", name="courierArrive_archive", methods={"GET"})
     * @param $id
     * @param CourierArriveRepository $repository
     * @return Response
     */
    public  function  archive($id, CourierArriveRepository $repository){


        return $this->render('_admin/arrive/archive.html.twig', [
            'titre'=>'Arrive',
            'data'=>$repository->getFichier($id),

        ]);
    }

    /**
     * @Route("/courier/{id}/show", name="courierArrive_show", methods={"GET"})
     * @param CourierArrive $courierArrive
     * @return Response
     */
    public function show(CourierArrive $courierArrive,$id,CourierArriveRepository $repository): Response
    {
        //$type = $courierArrive->getType();

        $form = $this->createForm(CourierArriveType::class, $courierArrive, [

            'method' => 'POST',
            'action' => $this->generateUrl('courierArrive_show', [
                'id' => $courierArrive->getId(),
            ])
        ]);

        return $this->render('_admin/arrive/voir.html.twig', [
            'titre'=>'ARRIVE',
            'data'=>$repository->getFichier($id),
            'courierArrive' => $courierArrive,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/courier/new", name="courierArrive_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UploaderHelper $uploaderHelper
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $em, UploaderHelper $uploaderHelper,CourierArriveRepository $repository): Response
    {


        $courierArrive = new CourierArrive();



        $form = $this->createForm(CourierArriveType::class, $courierArrive, [
            'method' => 'POST',
            'action' => $this->generateUrl('courierArrive_new')
        ]);


        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();
      // $type = $form->getData()->getType();
        if ($form->isSubmitted()) {
            $statut = 1;
            $redirect = $this->generateUrl('courierArrive');
            $brochureFile = $form->get('fichiers')->getData();

        //    dd($brochureFile);
            if ($form->isValid()) {
                //get('image_prod')->getData();

                foreach ($brochureFile as $image) {
                    $file = new File($image->getPath());
                    $newFilename = md5(uniqid()) . '.' . $file->guessExtension();
                    // $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move($this->getParameter('images_directory'), $newFilename);
                    $image->setPath($newFilename);
                }
                $courierArrive->setEtat(false);
                $courierArrive->setType('ARRIVE');
                $courierArrive->setCategorie('COURRIER');
                $courierArrive->setActive(1);
                $em->persist($courierArrive);
                $em->flush();

                $message = 'Opération effectuée avec succès';

                $this->addFlash('success', $message);

            }
            if ($isAjax) {
                return $this->json(compact('statut', 'message', 'redirect'));
            } else {
                if ($statut == 1) {
                    return $this->redirect($redirect);
                }
            }
        }

        return $this->render('_admin/arrive/new.html.twig', [
            'titre'=>'ARRIVE',
            'courierArrive' => $courierArrive,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/courier/{id}/edit", name="courierArrive_edit", methods={"GET","POST"})
     * @param Request $request
     * @param CourierArrive $courierArrive
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function edit(Request $request, CourierArrive $courierArrive, EntityManagerInterface $em,$id,CourierArriveRepository $repository): Response
    {


        $form = $this->createForm(CourierArriveType::class, $courierArrive, [
            'method' => 'POST',
            'action' => $this->generateUrl('courierArrive_edit', [
                'id' => $courierArrive->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();
       // $type = $form->getData()->getType();
        if ($form->isSubmitted()) {

            $redirect = $this->generateUrl('courierArrive');
            $brochureFile = $form->get('fichiers')->getData();

            if ($form->isValid()) {

               foreach ($brochureFile as $image) {
                    $file = new File($image->getPath());
                    $newFilename = md5(uniqid()) . '.' . $file->guessExtension();
                    // $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move($this->getParameter('images_directory'), $newFilename);
                    $image->setPath($newFilename);
                }
                $em->persist($courierArrive);
                $em->flush();

                $message = 'Opération effectuée avec succès';
                $statut = 1;
                $this->addFlash('success', $message);

            }

            if ($isAjax) {
                return $this->json(compact('statut', 'message', 'redirect'));
            } else {
                if ($statut == 1) {
                    return $this->redirect($redirect);
                }
            }
        }

        return $this->render('_admin/arrive/edit.html.twig', [
            'titre'=>'ARRIVE',
            'data'=>$repository->getFichier($id),
            'courierArrive' => $courierArrive,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/accuse/{id}", name="courierArrive_accuse_edit", methods={"GET","POST"})
     * @param Request $request
     * @param CourierArrive $courierArrive
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function accuse(Request $request, CourierArrive $courierArrive, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CourierArriveType::class, $courierArrive, [
            'method' => 'POST',
            'action' => $this->generateUrl('courierArrive_accuse_edit', [
                'id' => $courierArrive->getId(),
            ])
        ]);

        $file = new Fichier();
        $file->setPath("");

        $courierArrive->addFichier($file);

        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();
      //  $type = $form->getData()->getType();
        if ($form->isSubmitted()) {

            $redirect = $this->generateUrl('courierArrive');
            $brochureFile = $form->get('fichiers')->getData();

            if ($form->isValid()) {

                foreach ($brochureFile as $image) {
                    $file = new File($image->getPath());
                    $newFilename = md5(uniqid()) . '.' . $file->guessExtension();
                    // $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move($this->getParameter('images_directory'), $newFilename);
                    $image->setPath($newFilename);
                }
                $em->persist($courierArrive);
                $em->flush();

                $message = 'Opération effectuée avec succès';
                $statut = 1;
                $this->addFlash('success', $message);

            }

            if ($isAjax) {
                return $this->json(compact('statut', 'message', 'redirect'));
            } else {
                if ($statut == 1) {
                    return $this->redirect($redirect);
                }
            }
        }

        return $this->render('_admin/arrive/accuse.html.twig', [
            'titre'=>"ACCUSE DE RECEPTION",
            'courierArrive' => $courierArrive,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/courierArrive/delete/{id}", name="courierArrive_delete", methods={"POST","GET","DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param courierArrive $courierArrive
     * @return Response
     */
    public function delete($id,Request $request, EntityManagerInterface $em, CourierArrive $courierArrive): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'courierArrive_delete'
                    , [
                        'id' => $courierArrive->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $categorie = $em->getRepository(CourierArrive::class)->find($courierArrive->getId());
            $em->remove($categorie);
           // $em->remove($courierArrive);
            $em->flush();

            $redirect = $this->generateUrl('courierArrive');

            $message = 'Opération effectuée avec succès';

            $response = [
                'statut' => 1,
                'message' => $message,
                'redirect' => $redirect,
            ];

            $this->addFlash('success', $message);
            return $this->redirect($redirect);
           /* if (!$request->isXmlHttpRequest()) {
                return $this->redirect($redirect);
            } else {
                return $this->json($response);
            }*/


        }
        return $this->render('_admin/arrive/delete.html.twig', [
            'courierArrive' => $courierArrive,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/liste_tarife", name="liste_tarife_index", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function remplirSelect2Action(Request $request, EntityManagerInterface $em): Response
    {
        $response = new Response();
        if ($request->isXmlHttpRequest()) { // pour vérifier la présence d'une requete Ajax

            $id = "";
            $id = $request->get('id');

            if ($id) {

                $ensembles = $repository->listeDepartement($id);

                $arrayCollection = array();

                foreach ($ensembles as $item) {
                    $arrayCollection[] = array(
                        'id' => $item->getId(),
                        'libelle' => $item->getLibDepartement(),
                        // ... Same for each property you want
                    );
                }
                $data = json_encode($arrayCollection); // formater le résultat de la requête en json
                //dd($data);
                $response->headers->set('Content-TypeActe', 'application/json');
                $response->setContent($data);

            }

        }

        return $response;
    }

    /**
     * @Route("/courierArrive/{id}/active", name="courierArrive_active", methods={"GET"})
     * @param $id
     * @param CourierArrive $parent
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function active($id, CourierArrive $parent, EntityManagerInterface $entityManager): Response
    {

        if ($parent->getActive() == 1) {

            $parent->setActive(0);

        } else {

            $parent->setActive(1);

        }

        $entityManager->persist($parent);
        $entityManager->flush();
        return $this->json([
            'code' => 200,
            'message' => 'ça marche bien',
            'active' => $parent->getActive(),
        ], 200);

    }

    /**
     * @Route("/existe", name="exsite", methods={"GET","POST"})
     * @param CourierArriveRepository $repository
     * @param Request $request
     * @return Response
     */
    public function existe(CourierArriveRepository $repository,Request $request): Response
    {
        $response = new Response();
        $format="";
        $nombre = $repository->getNombre();
        $date = date('y');
        $format = $date.'-'.$nombre.' '.'A';

        if ($request->isXmlHttpRequest()) {




            $arrayCollection[] = array(
                'nom' =>  $format,

                // ... Same for each property you want
            );
            $data = json_encode($arrayCollection); // formater le résultat de la requête en json
            //dd($data);
            $response->headers->set('Content-TypeActe', 'application/json');
            $response->setContent($data);
        }
        return $this->json([
            'code' => 200,
            'message' => 'ça marche bien',
            'nom' => $format,
        ], 200);

    }
}
  