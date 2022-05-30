<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Services\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/admin")
 * il s'agit du parent des User
 */
class UserController extends AbstractController
{
 private $encoder;

 public function __construct(UserPasswordHasherInterface $encoder)
 {

     $this->encoder = $encoder;
 }

    /**
     * @Route("/user", name="user")
     * @param UserRepository $repository
     * @return Response
     */
    public function index(UserRepository $repository): Response
    {

        $pagination = $repository->findBy(['active'=>1]);

        return $this->render('_admin/user/index.html.twig', [
            'pagination'=>$pagination,
            'tableau'=>['nom'=>'nom','prenoms'=>'prenoms','email'=>'email'],
            'modal' => 'modal',
            'titre' => 'Liste des users',
            'critereTitre'=>'',
        ]);
    }

    /**
     * @Route("/user/new", name="user_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class,$user, [
            'method' => 'POST',
            'action' => $this->generateUrl('user_new')
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();
        if($form->isSubmitted())
        {
            $response = [];
            $redirect = $this->generateUrl('user');
            $statut = 1;
            //dd($form->isValid());
            if($form->isValid()==false){

                $password = $form->getData()->getPassword();

                $user->setPassword($this->encoder->hashPassword($user,$password));
                $user->setActive(1);
                $em->persist($user);

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

        return $this->render('_admin/user/new.html.twig', [
            'user' => $user,
            'titre' => 'Utulisateur',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,User $user, EntityManagerInterface  $em): Response
    {

        $form = $this->createForm(UserType::class,$user, [
            'method' => 'POST',
            'action' => $this->generateUrl('user_edit',[
                'id'=>$user->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {
            $response = [];
            $redirect = $this->generateUrl('user');

            if($form->isValid()){

                $password = $form->getData()->getPassword();

                $user->setPassword($this->enoder->hashPassword($user,$password));

                $em->persist($user);
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

        return $this->render('_admin/user/edit.html.twig', [
            'user' => $user,
            'titre' => 'Utulisateur',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/{id}/show", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        $form = $this->createForm(UserType::class,$user, [
            'method' => 'POST',
            'action' => $this->generateUrl('user_show',[
                'id'=>$user->getId(),
            ])
        ]);

        return $this->render('_admin/user/voir.html.twig', [
            'user' => $user,
            'titre' => 'Utulisateur',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/{id}/active", name="user_active", methods={"GET"})
     */
    public function active($id,User $user, SerializerInterface $serializer,EntityManagerInterface $entityManager): Response
    {

        if ($user->getActive() == 1){

            $user->setActive(0);

        }else{

            $user->setActive(1);

        }
        $json = $serializer->serialize($user, 'json', ['groups' => ['normal']]);
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->json([
            'code'=>200,
            'message'=>'ça marche bien',
            'active'=>$user->getActive(),
        ],200);


    }


    /**
     * @Route("/user/delete/{id}", name="user_delete", methods={"POST","GET","DELETE"})
     */
    public function delete(Request $request, EntityManagerInterface $em,User $user): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'user_delete'
                    ,   [
                        'id' => $user->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($user);
            $em->flush();

            $redirect = $this->generateUrl('user');

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
        return $this->render('_admin/user/delete.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
