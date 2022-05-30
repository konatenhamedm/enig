<?php

namespace App\Controller;

use App\Entity\Partenaire;
use App\Form\PartenaireType;
use App\Services\PaginationService;
use App\Services\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin")
 */
class PartenaireController extends AbstractController
{
    /**
     * @Route("/partenaire", name="partenaire")
     */
    public function index(PaginationService $paginationService): Response
    {
        $pagination = $paginationService->setEntityClass(Partenaire::class)->getData();

        return $this->render('admin/partenaire/index.html.twig', [
            'pagination' => $pagination,
            'tableau' => ['logo'=>'logo','libelle'=> 'Libelle'],
            'modal' => 'modal',
            'titre' => 'Liste des partenaires',
            'critereTitre'=>'',

        ]);
    }
    /**
     * @Route("/partenaire/{id}/show", name="partenaire_show", methods={"GET"})
     */
    public function show(Partenaire $partenaire): Response
    {
        $form = $this->createForm(PartenaireType::class,$partenaire, [
            'method' => 'POST',
            'action' => $this->generateUrl('partenaire_show',[
                'id'=>$partenaire->getId(),
            ])
        ]);

        return $this->render('admin/partenaire/voir.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/partenaire/new", name="partenaire_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UploaderHelper $uploaderHelper
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface  $em,UploaderHelper  $uploaderHelper): Response
    {
        $partenaire = new Partenaire();
        $form = $this->createForm(PartenaireType::class,$partenaire, [
            'method' => 'POST',
            'action' => $this->generateUrl('partenaire_new')
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {
            $redirect = $this->generateUrl('partenaire');

            if($form->isValid()){
                $uploadedFile = $form['logo']->getData();
//dd($uploadedFile);
                if ($uploadedFile) {
                    $newFilename = $uploaderHelper->uploadImage($uploadedFile);
                    $partenaire->setLogo($newFilename);
                }
                $partenaire->setActive(1);
                $em->persist($partenaire);
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

        return $this->render('admin/partenaire/new.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/partenaire/{id}/edit", name="partenaire_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Partenaire $partenaire
     * @param EntityManagerInterface $em
     * @param UploaderHelper $uploaderHelper
     * @return Response
     */
    public function edit(Request $request,partenaire $partenaire, EntityManagerInterface  $em,UploaderHelper  $uploaderHelper): Response
    {

        $form = $this->createForm(PartenaireType::class,$partenaire, [
            'method' => 'POST',
            'action' => $this->generateUrl('partenaire_edit',[
                'id'=>$partenaire->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {

            $redirect = $this->generateUrl('partenaire');

            if($form->isValid()){
                $uploadedFile = $form['logo']->getData();
//dd($uploadedFile);
                if ($uploadedFile) {
                    $newFilename = $uploaderHelper->uploadImage($uploadedFile);
                    $partenaire->setLogo($newFilename);
                }
                $em->persist($partenaire);
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

        return $this->render('admin/partenaire/edit.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/partenaire/delete/{id}", name="partenaire_delete", methods={"POST","GET","DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Partenaire $partenaire
     * @return Response
     */
    public function delete(Request $request, EntityManagerInterface $em,partenaire $partenaire): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'partenaire_delete'
                    ,   [
                        'id' => $partenaire->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($partenaire);
            $em->flush();

            $redirect = $this->generateUrl('partenaire');

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
        return $this->render('admin/partenaire/delete.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/partenaire/{id}/active", name="partenaire_active", methods={"GET"})
     * @param $id
     * @param partenaire $parent
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function active(Partenaire $parent,EntityManagerInterface $entityManager): Response
    {
       // $entityManager = $this->getDoctrine()->getManager();


        if ($parent->getActive() == 1){

            $parent->setActive(0);

        }else{

            $parent->setActive(1);

        }

        $entityManager->persist($parent);
        $entityManager->flush();
        return $this->json([
            'code'=>200,
            'message'=>'ça marche bien',
            'active'=>$parent->getActive(),
        ],200);
    }

}
