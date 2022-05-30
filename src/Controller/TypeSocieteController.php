<?php

namespace App\Controller;

use App\Entity\TypeSociete;
use App\Form\TypeSocieteType;
use App\Repository\TypeSocieteRepository;
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
class TypeSocieteController extends AbstractController
{

    /**
     * @Route("/typeSociete", name="typeSociete")
     * @param TypeSocieteRepository $repository
     * @return Response
     */
    public function index(TypeSocieteRepository $repository): Response
    {

        $pagination = $repository->findBy(['active'=>1]);
        //dd($pagination);
        return $this->render('_admin/typeSociete/index.html.twig', [
            'pagination' => $pagination,
            'tableau' => [
                'libelle' => 'libelle',
                'sigle' => 'sigle',

            ],
            'modal' => 'modal',
            'titre' => 'Liste des types societes',

        ]);
    }

    /**
     * @Route("/archive/{id}/TYPE SOCIETE", name="typeSociete_archive", methods={"GET"})
     * @param $id
     * @param TypeSocieteRepository $repository
     * @return Response
     */
    public  function  archive($id, TypeSocieteRepository $repository){


        return $this->render('_admin/typeSociete/archive.html.twig', [
            'titre'=>'Type societe',
        ]);
    }

    /**
     * @Route("/typeSociete/{id}/show", name="typeSociete_show", methods={"GET"})
     * @param TypeSociete $typeSociete
     * @param $id
     * @param TypeSocieteRepository $repository
     * @return Response
     */
    public function show(TypeSociete $typeSociete,$id,TypeSocieteRepository $repository): Response
    {
        //$type = $typeSociete->getType();
//dd($repository->getFichier($id));
        $form = $this->createForm(TypeSocieteType::class, $typeSociete, [

            'method' => 'POST',
            'action' => $this->generateUrl('typeSociete_show', [
                'id' => $typeSociete->getId(),
            ])
        ]);

        return $this->render('_admin/typeSociete/voir.html.twig', [
            'titre'=>'TYPE SOCIETE',
            'typeSociete' => $typeSociete,
            'form' => $form->createView(),
            'data'=>$repository->getFichier($id),
        ]);
    }

    /**
     * @Route("/typeSociete/new", name="typeSociete_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UploaderHelper $uploaderHelper
     * @param TypeSocieteRepository $repository
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $em, UploaderHelper $uploaderHelper,TypeSocieteRepository $repository): Response
    {


        $typeSociete = new TypeSociete();



        $form = $this->createForm(TypeSocieteType::class, $typeSociete, [
            'method' => 'POST',
            'action' => $this->generateUrl('typeSociete_new')
        ]);


        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();
      // $type = $form->getData()->getType();
        if ($form->isSubmitted()) {
            $statut = 1;
            $redirect = $this->generateUrl('typeSociete');


        //    dd($brochureFile);
            if ($form->isValid()) {


                $typeSociete->setActive(1);
                $em->persist($typeSociete);
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

        return $this->render('_admin/typeSociete/new.html.twig', [
            'titre'=>'TYPE SOCIETE',
            'typeSociete' => $typeSociete,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/typeSociete/{id}/edit", name="typeSociete_edit", methods={"GET","POST"})
     * @param Request $request
     * @param TypeSociete $typeSociete
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function edit(Request $request, TypeSociete $typeSociete, EntityManagerInterface $em,$id,TypeSocieteRepository $repository): Response
    {


        $form = $this->createForm(TypeSocieteType::class, $typeSociete, [
            'method' => 'POST',
            'action' => $this->generateUrl('typeSociete_edit', [
                'id' => $typeSociete->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();
       // $type = $form->getData()->getType();
        if ($form->isSubmitted()) {

            $redirect = $this->generateUrl('typeSociete');


            if ($form->isValid()) {


                $em->persist($typeSociete);
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

        return $this->render('_admin/typeSociete/edit.html.twig', [
            'titre'=>'TYPE SOCIETE',
            'data'=>$repository->getFichier($id),
            'typeSociete' => $typeSociete,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/accuse/{id}", name="typeSociete_accuse_edit", methods={"GET","POST"})
     * @param Request $request
     * @param TypeSociete $typeSociete
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function accuse(Request $request, TypeSociete $typeSociete, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TypeSocieteType::class, $typeSociete, [
            'method' => 'POST',
            'action' => $this->generateUrl('typeSociete_accuse_edit', [
                'id' => $typeSociete->getId(),
            ])
        ]);


        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();
      //  $type = $form->getData()->getType();
        if ($form->isSubmitted()) {

            $redirect = $this->generateUrl('typeSociete');

            if ($form->isValid()) {

                $em->persist($typeSociete);
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

        return $this->render('_admin/typeSociete/accuse.html.twig', [
            'titre'=>"ACCUSE DE RECEPTION",
            'typeSociete' => $typeSociete,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/typeSociete/delete/{id}", name="typeSociete_delete", methods={"POST","GET","DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param typeSociete $typeSociete
     * @return Response
     */
    public function delete($id,Request $request, EntityManagerInterface $em, typeSociete $typeSociete): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'typeSociete_delete'
                    , [
                        'id' => $typeSociete->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $categorie = $em->getRepository(typeSociete::class)->find($typeSociete->getId());
            $em->remove($categorie);
           // $em->remove($typeSociete);
            $em->flush();

            $redirect = $this->generateUrl('typeSociete');

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
        return $this->render('_admin/typeSociete/delete.html.twig', [
            'typeSociete' => $typeSociete,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/typeSociete/{id}/active", name="typeSociete_active", methods={"GET"})
     * @param $id
     * @param TypeSociete $parent
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function active($id, TypeSociete $parent, EntityManagerInterface $entityManager): Response
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

}
  