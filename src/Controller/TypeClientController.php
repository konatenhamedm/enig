<?php

namespace App\Controller;

use App\Repository\TypeClientRepository;
use App\Services\PaginationService;
use App\Services\Services;
use App\Entity\TypeClient;
use App\Form\TypeClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/admin")
 * il s'agit du typeClient des module
 */
class TypeClientController extends AbstractController
{
    /**
     * @Route("/typeClient", name="typeClient")
     * @param PaginationService $paginationService
     * @return Response
     */
    public function index(TypeClientRepository $repository): Response
    {

        $pagination = $repository->findBy(['active'=>1]);

        return $this->render('_admin/typeClient/index.html.twig', [
           'pagination'=>$pagination,
            'tableau'=>['titre'=>'titre'],
            'modal' => 'modal',

            'titre' => 'Liste des types clients',

        ]);
    }

    /**
     * @Route("/typeClient/new", name="typeClient_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface  $em): Response
    {
        $typeClient = new TypeClient();
        $form = $this->createForm(TypeClientType::class,$typeClient, [
            'method' => 'POST',
            'action' => $this->generateUrl('typeClient_new')
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted() && $form->isValid())
        {
            $response = [];
            $redirect = $this->generateUrl('typeClient');

         /*  if($form->isValid()){*/
               $typeClient->setActive(1);
               $em->persist($typeClient);
               $em->flush();

               $message       = 'Opération effectuée avec succès';
               $statut = 1;
               $this->addFlash('success', $message);

         /*  }*/
            if ($isAjax) {
                return $this->json( compact('statut', 'message', 'redirect'));
            } else {
                if ($statut == 1) {
                    return $this->redirect($redirect);
                }
            }
        }

        return $this->render('_admin/typeClient/new.html.twig', [
            'typeClient' => $typeClient,
            'form' => $form->createView(),
            'titre' => 'Type Client',
        ]);
    }

    /**
     * @Route("/typeClient/{id}/edit", name="typeClient_edit", methods={"GET","POST"})
     * @param Request $request
     * @param TypeClient $typeClient
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function edit(Request $request,TypeClient $typeClient, EntityManagerInterface  $em): Response
    {

        $form = $this->createForm(TypeClientType::class,$typeClient, [
            'method' => 'POST',
            'action' => $this->generateUrl('typeClient_edit',[
                'id'=>$typeClient->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {

            $response = [];
            $redirect = $this->generateUrl('typeClient');

            if($form->isValid()){
                $em->persist($typeClient);
                $em->flush();

                $message       = 'Opération effectuée avec succès';
                $statut = 1;
                $this->addFlash('success', $message);

            }

            if ($isAjax) {
                return $this->json( compact('statut', 'message', 'redirect'));
            } else {
                if ($statut == 1) {
                    return $this->redirect($redirect);
                }
            }
        }

        return $this->render('_admin/typeClient/edit.html.twig', [
            'typeClient' => $typeClient,
            'form' => $form->createView(),
            'titre' => 'Type Client',
        ]);
    }

    /**
     * @Route("/typeClient/{id}/show", name="typeClient_show", methods={"GET"})
     * @param TypeClient $typeClient
     * @return Response
     */
    public function show(TypeClient $typeClient): Response
    {
        $form = $this->createForm(TypeClientType::class,$typeClient, [
            'method' => 'POST',
            'action' => $this->generateUrl('typeClient_show',[
                'id'=>$typeClient->getId(),
            ])
        ]);

        return $this->render('_admin/typeClient/voir.html.twig', [
            'typeClient' => $typeClient,
            'titre' => 'Type Client',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/typeClient/{id}/active", name="typeClient_active", methods={"GET"})
     * @param $id
     * @param TypeClient $typeClient
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function active($id,TypeClient $typeClient, EntityManagerInterface $entityManager): Response
    {

        if ($typeClient->getActive() == 1){

            $typeClient->setActive(0);

        }else{

            $typeClient->setActive(1);

        }
        $entityManager->persist($typeClient);
        $entityManager->flush();
        return $this->json([
            'code'=>200,
            'message'=>'ça marche bien',
            'active'=>$typeClient->getActive(),
        ],200);


    }


    /**
     * @Route("/typeClient/delete/{id}", name="typeClient_delete", methods={"POST","GET","DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param TypeClient $typeClient
     * @return Response
     */
    public function delete(Request $request, EntityManagerInterface $em,TypeClient $typeClient): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'typeClient_delete'
                    ,   [
                        'id' => $typeClient->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($typeClient);
            $em->flush();

            $redirect = $this->generateUrl('typeClient');

            $message = 'Opération effectuée avec succès';

            $response = [
                'statut'   => 1,
                'message'  => $message,
                'redirect' => $redirect,
            ];

            $this->addFlash('success', $message);

            if (!$request->isXmlHttpRequest()) {
                return $this->redirect($redirect);
            } else {
                return $this->json($response);
            }



        }
        return $this->render('_admin/typeClient/delete.html.twig', [
            'typeClient' => $typeClient,
            'form' => $form->createView(),
        ]);
    }

}
