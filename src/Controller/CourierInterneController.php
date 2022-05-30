<?php

namespace App\Controller;

use App\Entity\CourierArrive;
use App\Entity\Fichier;
use App\Form\CourierArriveType;
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
class CourierInterneController extends AbstractController
{

    /**
     * @Route("/courrier-interne", name="courierInterne")
     * @param CourierArriveRepository $repository
     * @return Response
     */
    public function interne(CourierArriveRepository $repository): Response
    {

        $interne = $repository->findBy(['type'=>'INTERNE','etat'=>0,'active'=>1]);

        $interne_finalise = $repository->findBy(['type'=>'INTERNE','etat'=>1,'active'=>1]);

        return $this->render('_admin/interne/index.html.twig', [
            'pagination' => $interne,
            'finalise' => $interne_finalise,
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
            'titre' => 'Liste des courriers interne',

        ]);
    }

    /**
     * @Route("/archive/{id}/interne", name="courierInterne_archive", methods={"GET"})
     * @param $id
     * @param CourierArriveRepository $repository
     * @return Response
     */
    public  function  archive($id, CourierArriveRepository $repository){


        return $this->render('_admin/arrive/archive.html.twig', [
            'titre'=>'Interne',
            'data'=>$repository->getFichier($id),

        ]);
    }

    /**
     * @Route("/courrier-interne/{id}/show", name="courierInterne_show", methods={"GET"})
     * @param CourierArrive $courierArrive
     * @return Response
     */
    public function show(CourierArrive $courierArrive,$id,CourierArriveRepository $repository): Response
    {
        $type = $courierArrive->getType();

        $form = $this->createForm(CourierArriveType::class, $courierArrive, [

            'method' => 'POST',
            'action' => $this->generateUrl('courierInterne_show', [
                'id' => $courierArrive->getId(),
            ])
        ]);

        return $this->render('_admin/interne/voir.html.twig', [
            'titre'=>'INTERNE',
            'data'=>$repository->getFichier($id),
            'courierArrive' => $courierArrive,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/courrier-interne/{id}/accuse", name="courierInterne_recep", methods={"GET","POST"})
     * @param Request $request
     * @param CourierArrive $courierArrive
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function accuse(Request $request, CourierArrive $courierArrive, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CourierArriveType::class, $courierArrive, [
            'method' => 'POST',
            'action' => $this->generateUrl('courierInterne_recep', [
                'id' => $courierArrive->getId(),
            ])
        ]);


        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();
        $type = $form->getData()->getType();
        if ($form->isSubmitted()) {

            $redirect = $this->generateUrl('courierInterne');
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
     * @Route("/courrier-interne/new", name="courierInterne_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UploaderHelper $uploaderHelper
     * @param CourierArriveRepository $repository
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $em, UploaderHelper $uploaderHelper,CourierArriveRepository $repository): Response
    {


        $courierArrive = new CourierArrive();



        $form = $this->createForm(CourierArriveType::class, $courierArrive, [
            'method' => 'POST',
            'action' => $this->generateUrl('courierInterne_new')
        ]);


        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();
      // $type = $form->getData()->getType();
        if ($form->isSubmitted()) {
            $statut = 1;
            $redirect = $this->generateUrl('courierInterne');
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
                $courierArrive->setType('INTERNE');
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

        return $this->render('_admin/interne/new.html.twig', [
            'titre'=>'INTERNE',
            'courierArrive' => $courierArrive,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/courrier-interne/{id}/edit", name="courierInterne_edit", methods={"GET","POST"})
     * @param Request $request
     * @param CourierArrive $courierArrive
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function edit(Request $request, CourierArrive $courierArrive, EntityManagerInterface $em,$id,CourierArriveRepository $repository): Response
    {

        $form = $this->createForm(CourierArriveType::class, $courierArrive, [
            'method' => 'POST',
            'action' => $this->generateUrl('courierInterne_edit', [
                'id' => $courierArrive->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();
        //$type = $form->getData()->getType();
        if ($form->isSubmitted()) {

            $redirect = $this->generateUrl('courierInterne');
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

        return $this->render('_admin/interne/edit.html.twig', [
            'titre'=>'INTERNE',
            'data'=>$repository->getFichier($id),
            'courierArrive' => $courierArrive,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/courrier-interne/delete/{id}", name="courierInterne_delete", methods={"POST","GET","DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param courierArrive $courierArrive
     * @return Response
     */
    public function delete(Request $request, EntityManagerInterface $em, CourierArrive $courierArrive): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'courierInterne_delete'
                    , [
                        'id' => $courierArrive->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($courierArrive);
            $em->flush();

            $redirect = $this->generateUrl('courierInterne');

            $message = 'Opération effectuée avec succès';

            $response = [
                'statut' => 1,
                'message' => $message,
                'redirect' => $redirect,
            ];

            $this->addFlash('success', $message);

            if (!$request->isXmlHttpRequest()) {
                return $this->redirect($redirect);
            } else {
                return $this->json($response);
            }


        }
        return $this->render('_admin/interne/delete.html.twig', [
            'courierArrive' => $courierArrive,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/liste_tarife", name="liste_tarife_index", methods={"GET","POST"})
     * @param Request $request
     * @param DepartementRepository $repository
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function remplirSelect2Action(Request $request, DepartementRepository $repository, EntityManagerInterface $em): Response
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
     * @Route("/courrier-interne/{id}/active", name="courierInterne_active", methods={"GET"})
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
     * @Route("/existe_interne", name="exsite_interne", methods={"GET","POST"})
     * @param CourierArriveRepository $repository
     * @param Request $request
     * @return Response
     */
    public function existeInterne(CourierArriveRepository $repository,Request $request): Response
    {
        $response = new Response();
        $format="";
        if ($request->isXmlHttpRequest()) {
            $nombre = $repository->getNombre();

            $date = date('y');
            $format = $date.'-'.$nombre.' '.'I';


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
  