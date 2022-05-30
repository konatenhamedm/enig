<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Form\MarqueType;
use App\Repository\MarqueRepository;
use App\Services\PaginationService;
use App\Services\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @Route("/admin")
 */
class MarqueController extends AbstractController
{
    /**
     * @Route("/marque", name="marque")
     * @param PaginationService $paginationService
     * @return Response
     */
    public function index(PaginationService $paginationService): Response
    {
        $pagination = $paginationService->setEntityClass(Marque::class)->getData();

        return $this->render('admin/marque/index.html.twig', [
            'pagination' => $pagination,
            'tableau' => [
                'logo'=> 'logo',
                'libelle'=> 'libelle',
            ],
            'critereTitre'=>'',
            'modal' => 'modal',
            'position' => 4,
            'active'=> 3,
            'titre' => 'Liste des marques',

        ]);
    }
    /**
     * @Route("/marque/{id}/show", name="marque_show", methods={"GET"})
     */
    public function show(Marque $marque): Response
    {
        $form = $this->createForm(MarqueType::class,$marque, [
            'method' => 'POST',
            'action' => $this->generateUrl('marque_show',[
                'id'=>$marque->getId(),
            ])
        ]);

        return $this->render('admin/marque/voir.html.twig', [
            'marque' => $marque,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/marque/new", name="marque_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UploaderHelper $uploaderHelper
     * @param MarqueRepository $repository
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface  $em,UploaderHelper  $uploaderHelper,MarqueRepository $repository): Response
    {
        $marque = new Marque();
        $form = $this->createForm(MarqueType::class,$marque ,[
            'method' => 'POST',
            'action' => $this->generateUrl('marque_new')
        ]);

        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {
            $response = [];
            $statut = 1;
            $redirect = $this->generateUrl('marque');

            if($form->isValid()){

                $uploadedFile = $form['logo']->getData();
//dd($uploadedFile);
                if ($uploadedFile) {
                    $newFilename = $uploaderHelper->uploadImage($uploadedFile);
                    $marque->setLogo($newFilename);
                }
              //  $marque->setActive(1);
                $em->persist($marque);
                $em->flush();

                $message       = 'Opération effectuée avec succès';

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

        return $this->render('admin/marque/new.html.twig', [
            'marque' => $marque,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/marque/{id}/edit", name="marque_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Marque $marque
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function edit(Request $request,marque $marque, EntityManagerInterface  $em): Response
    {

        $form = $this->createForm(MarqueType::class,$marque, [
            'method' => 'POST',
            'action' => $this->generateUrl('marque_edit',[
                'id'=>$marque->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {

            $response = [];
            $redirect = $this->generateUrl('marque');

            if($form->isValid()){
                $em->persist($marque);
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

        return $this->render('admin/marque/edit.html.twig', [
            'marque' => $marque,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/marque/delete/{id}", name="marque_delete", methods={"POST","GET","DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Marque $marque
     * @return Response
     */
    public function delete(Request $request, EntityManagerInterface $em,Marque $marque): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'marque_delete'
                    ,   [
                        'id' => $marque->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($marque);
            $em->flush();

            $redirect = $this->generateUrl('marque');

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
        return $this->render('admin/marque/delete.html.twig', [
            'marque' => $marque,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/marque/{id}/active", name="marque_active", methods={"GET"})
     * @param $id
     * @param Marque $marque
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function active($id,Marque $marque, SerializerInterface $serializer,EntityManagerInterface $entityManager): Response
    {

        if ($marque->getActive() == 1){

            $marque->setActive(0);

        }else{

            $marque->setActive(1);

        }
       /* $json = $serializer->serialize($marque, 'json', ['groups' => ['normal']]);*/
        $entityManager->persist($marque);
        $entityManager->flush();
        return $this->json([
            'code'=>200,
            'message'=>'ça marche bien',
            'active'=>$marque->getActive(),
        ],200);

    }
}
  