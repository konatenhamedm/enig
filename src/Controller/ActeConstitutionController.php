<?php

namespace App\Controller;

use App\Entity\ActeConstitution;
use App\Entity\FichierConstitution;
use App\Form\ActeConstitutionType;
use App\Form\FichierConstitutionType;
use App\Repository\ActeConstitutionRepository;
use App\Repository\DocumentsRepository;
use App\Repository\FichierConstitutionRepository;
use App\Services\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


/**
 * @Route("/admin")
 */
class ActeConstitutionController extends AbstractController
{

    /**
     * @Route("/acteConstitution", name="acteConstitution")
     * @param ActeConstitutionRepository $repository
     * @return Response
     */
    public function index(ActeConstitutionRepository $repository): Response
    {

        $pagination = $repository->findBy(['etat'=>'0','active'=>1]);
        $finalise = $repository->findBy(['etat'=>'1','active'=>1]);
        //dd($pagination);
        return $this->render('_admin/acteConstitution/index.html.twig', [
            'pagination' => $pagination,
            'finalise' => $finalise,
            'tableau' => [
                'form' => 'form',
                'denomination' => 'denomination',
                'sigle' => 'sigle',
                'client' => 'client',
            ],
            'modal' => 'modal',
            'titre' => 'Liste des acte de constitution',

        ]);
    }

    /**
     * @Route("/archive/{id}/constitution", name="acteConstitution_archive", methods={"GET","POST"})
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param $id
     * @param ActeConstitution $acteConstitution
     * @param ActeConstitutionRepository $repository
     * @param DocumentsRepository $documentsRepository
     * @return Response
     */
    public  function  archive(EntityManagerInterface $em,Request $request,$id,ActeConstitution $acteConstitution, FichierConstitutionRepository $repository){

        $form = $this->createForm(acteConstitutionType::class, $acteConstitution, [
            'method' => 'POST',
            'action' => $this->generateUrl('acteConstitution_archive', [
                'id' => $acteConstitution->getId(),
            ])
        ]);

        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();
        // $type = $form->getData()->getType();
        if ($form->isSubmitted() && $form->isValid()) {

            $redirect = $this->generateUrl('acteConstitution');
            $brochureFile = $form->get('fichierConstitutions')->getData();

            //dd($brochureFile);
                foreach ($brochureFile as $image) {
                    //dd($image->getPath());
                     if (str_contains($image->getPath(),'.tmp')){
                         $file = new File($image->getPath());
                         $newFilename = md5(uniqid()) . '.' . $file->guessExtension();
                         // $fileName = md5(uniqid()).'.'.$file->guessExtension();
                         $file->move($this->getParameter('images_directory'), $newFilename);
                         $image->setPath($newFilename);


                     }

                }
               // $acteConstitution->setObjet($form->getData()->getObjet());
                $em->persist($acteConstitution);
                $em->flush();

                $message = 'Opération effectuée avec succès';
                $statut = 1;
                $this->addFlash('success', $message);


            return $this->redirect($redirect);
        }


//dd($documentsRepository->getFichier($acteConstitution->getForm()->getId()));
        return $this->render('_admin/acteConstitution/archive.html.twig', [
            'titre'=>'Acte de constitution',
            'data'=>$repository->getFichier($id),
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/acteConstitution/{id}/show", name="acteConstitution_show", methods={"GET"})
     * @param ActeConstitution $acteConstitution
     * @param $id
     * @param ActeConstitutionRepository $repository
     * @return Response
     */
    public function show(ActeConstitution $acteConstitution,$id,ActeConstitutionRepository $repository): Response
    {
        //$type = $acteConstitution->getType();

        $form = $this->createForm(acteConstitutionType::class, $acteConstitution, [

            'method' => 'POST',
            'action' => $this->generateUrl('acteConstitution_show', [
                'id' => $acteConstitution->getId(),
            ])
        ]);

        return $this->render('_admin/acteConstitution/voir.html.twig', [
            'titre'=>'Acte de constitution',
            'acteConstitution' => $acteConstitution,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/acteConstitution/new", name="acteConstitution_new", methods={"GET","POST"})
     * @param DocumentsRepository $documentsRepository
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UploaderHelper $uploaderHelper
     * @param ActeConstitutionRepository $repository
     * @return Response
     */
    public function new(DocumentsRepository $documentsRepository,Request $request, EntityManagerInterface $em, UploaderHelper $uploaderHelper,ActeConstitutionRepository $repository): Response
    {


        $acteConstitution = new ActeConstitution();


        $form = $this->createForm(acteConstitutionType::class, $acteConstitution, [
            'method' => 'POST',
            'action' => $this->generateUrl('acteConstitution_new')
        ]);


        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();
      // $type = $form->getData()->getType();
        if ($form->isSubmitted() ) {
        $lignes = $documentsRepository->getFichier($form->getData()->getForm()->getId());

            foreach($lignes as $ligne){
                $constitution = new FichierConstitution();
                $constitution->setLibelle($ligne['libelle']);
                $constitution->setEtat(false);
                ;
                $acteConstitution->addFichierConstitution($constitution);
            }
           // dd($form->getData()->getForm()->getId());
            $statut = 1;
            $redirect = $this->generateUrl('acteConstitution');
            //dd($form->isValid());
            if ($form->isValid()){


                $acteConstitution->setActive(1);
               $acteConstitution->setEtat(false);
                $em->persist($acteConstitution);
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

        return $this->render('_admin/acteConstitution/new.html.twig', [
            'titre'=>'Acte de constitution',
            'acteConstitution' => $acteConstitution,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/acteConstitution/{id}/edit", name="acteConstitution_edit", methods={"GET","POST"})
     * @param Request $request
     * @param ActeConstitution $acteConstitution
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function edit(Request $request, ActeConstitution $acteConstitution, EntityManagerInterface $em,$id,ActeConstitutionRepository $repository): Response
    {

        $form = $this->createForm(acteConstitutionType::class, $acteConstitution, [
            'method' => 'POST',
            'action' => $this->generateUrl('acteConstitution_edit', [
                'id' => $acteConstitution->getId(),
            ])
        ]);

        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();
       // $type = $form->getData()->getType();
        if ($form->isSubmitted()) {

            $redirect = $this->generateUrl('acteConstitution');


            if ($form->isValid()) {

                $em->persist($acteConstitution);
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

        return $this->render('_admin/acteConstitution/edit.html.twig', [
            'titre'=>'Acte de constitution',
            'acteConstitution' => $acteConstitution,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/accuse/{id}", name="acteConstitution_accuse_edit", methods={"GET","POST"})
     * @param Request $request
     * @param ActeConstitution $acteConstitution
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function accuse(Request $request, ActeConstitution $acteConstitution, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ActeConstitutionType::class, $acteConstitution, [
            'method' => 'POST',
            'action' => $this->generateUrl('acteConstitution_accuse_edit', [
                'id' => $acteConstitution->getId(),
            ])
        ]);

        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();
      //  $type = $form->getData()->getType();
        if ($form->isSubmitted()) {

            $redirect = $this->generateUrl('acteConstitution');
            $brochureFile = $form->get('fichiers')->getData();

            if ($form->isValid()) {

                foreach ($brochureFile as $image) {
                    $file = new File($image->getPath());
                    $newFilename = md5(uniqid()) . '.' . $file->guessExtension();
                    // $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move($this->getParameter('images_directory'), $newFilename);
                    $image->setPath($newFilename);
                }
                $em->persist($acteConstitution);
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

        return $this->render('_admin/acteConstitution/accuse.html.twig', [
            'titre'=>"ACCUSE DE RECEPTION",
            'acteConstitution' => $acteConstitution,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/acteConstitution/delete/{id}", name="acteConstitution_delete", methods={"POST","GET","DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ActeConstitution $acteConstitution
     * @return Response
     */
    public function delete($id,Request $request, EntityManagerInterface $em, ActeConstitution $acteConstitution): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'acteConstitution_delete'
                    , [
                        'id' => $acteConstitution->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $categorie = $em->getRepository(acteConstitution::class)->find($acteConstitution->getId());
            $em->remove($categorie);
           // $em->remove($acteConstitution);
            $em->flush();

            $redirect = $this->generateUrl('acteConstitution');

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
        return $this->render('_admin/acteConstitution/delete.html.twig', [
            'acteConstitution' => $acteConstitution,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/acteConstitution/{id}/active", name="acteConstitution_active", methods={"GET"})
     * @param $id
     * @param acteConstitution $parent
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function active($id, acteConstitution $parent, EntityManagerInterface $entityManager): Response
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
  