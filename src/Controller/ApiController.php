<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Repository\GroupeRepository;
use App\Services\MailerService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api",methods={"GET"})
     * la normalisation consiste a transformer un objet a un tableau assiciatif
     * @param GroupeRepository $groupeRepository
     * @param NormalizerInterface $normalizer
     * @return Response
     */
    public function index(GroupeRepository $groupeRepository, NormalizerInterface $normalizer)
    {
        $group = $groupeRepository->findAll();
        //dd($normalizer->normalize($group,null,["groups"=>"groupe:read"]));
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    /**
     * @Route("/mail", name="mail",methods={"GET"})
     * @param MailerService $mailerService
     * @return Response
     */
    public function sendEmail(MailerService $mailerService): Response
    {
        $mailerService->send(
            'Bonsoir monsieur',
            'konatenvaly@gmail.com',
            "konatenhamed@gmail.com",
            "_admin/contact/template.html.twig",
            [
                'message' =>  'Bonsoir monsieur',
                'email' =>  'konatenhamed@gmail.com',
                'nom' =>  'Konate',
                'prenom' =>  'Hamed',
                'telephone' =>  '0704314164'
            ]
        );
return  $this->redirectToRoute('agenda');
        // ...
    }

    /**
     * @Route("/api/{id}/edit" , name="api_edit",methods={"PUT"})
     *
     * cette methode met a jour lenregistrement et la
     * cree lorsquelle nexiste pas
     * @param Calendar|null $calendar
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     * @throws \Exception
     */
    public function calendar(?Calendar $calendar, Request $request,EntityManagerInterface $em)
    {
        $donnees = json_decode($request->getContent());
//dd($donnees);
        if (
            isset($donnees->title) && !empty($donnees->title) &&
            isset($donnees->start) && !empty($donnees->start) &&
            isset($donnees->description) && !empty($donnees->description) &&
            isset($donnees->backgroundColor) && !empty($donnees->backgroundColor) &&
            isset($donnees->borderColor) && !empty($donnees->borderColor) &&
            isset($donnees->textColor) && !empty($donnees->textColor)
        ) {
            // les donnnees sont completes
            $code = 200;
            if (!$calendar) {
                $calendar = new Calendar();
                $code = 201;
            }
            $calendar->setActive(1);
            $calendar->setTitle($donnees->title);
            $calendar->setDescription($donnees->description);
            $calendar->setStart(new \DateTime($donnees->start));
            if ($donnees->allDay == false && $donnees->oldallDay == true){
                $calendar->setEnd(new \DateTime($donnees->start));
            }
            if($donnees->allDay){
                $calendar->setEnd(new \DateTime($donnees->start));
            }
            else{
                $calendar->setEnd(new \DateTime($donnees->end));
            }
            $calendar->setAllDay($donnees->allDay);
            $calendar->setBackgroundColor($donnees->backgroundColor);
            $calendar->setBorderColor($donnees->borderColor);
            $calendar->setTextColor($donnees->textColor);

            $em->persist($calendar);
            $em->flush();

            return new Response('ok',$code);


        } else {
            // les donnnees sont incompletes
            return new Response("Données incompletes",404);
        }

    }


}
