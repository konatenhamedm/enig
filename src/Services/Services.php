<?php

namespace App\Services;

use App\Entity\Categorie;
use App\Entity\Groupe;
use App\Entity\Parametre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as container;
use Symfony\Component\HttpFoundation\RequestStack;

class Services
{

    private $em;
    private $route;
    private $container;

    public function __construct(EntityManagerInterface $em, RequestStack $route, Container $container)
    {
        $this->em = $em;
        $this->route = $route->getCurrentRequest()->attributes->get('_route');
        $this->container = $container->get('router')->getRouteCollection()->all();
//dd($this->container);
    }

    public function getRoute()
    {

        return $this->route;
    }

    public function listeModule()
    {
        $repo = $this->em->getRepository(Groupe::class)->afficheModule();
//dd($repo);
        return $repo;
    }

    public function findParametre()
    {
        $repo = $this->em->getRepository(Parametre::class)->findParametre();
        return $repo;
    }

    public function liste()
    {
        $repo = $this->em->getRepository(Groupe::class)->afficheGroupes();

        return $repo;
    }

    public function listeParent()
    {
        $repo = $this->em->getRepository(Groupe::class)->affiche();

        return $repo;
    }
    public function listeCategorie(){
        $repo = $this->em->getRepository(Categorie::class)->listeCategorie();

        return $repo;
    }

    public function listeLien()
    {
        $array = [
            'module'=>'module',
            'agenda'=>'agenda',
            'typeClient'=>'typeClient',
            'groupe'=>'groupe',
            'parent'=>'parent',
            'parametre'=>'parametre',
            'typeSociete'=>'typeSociete',
            'acteConstitution'=>'acteConstitution',
            'user'=>'user',
            'produit'=>'produit',
            'frais'=>'frais',
            'categorie'=>'categorie',
            'acte'=>'acte',
            'typeActe'=>'typeActe',
            'client'=>'client',
            'courierArrive'=>'courierArrive',
            'courierDepart'=>'courierDepart',
            'courierInterne'=>'courierInterne',
            'calendar'=>'calendar',
        ];
     /*   foreach ($this->container as $el=> $params) {
          $resultat=  $params->getDefaults();
           /// dd($params);
            if (stripos($params, '_') !== FALSE) {
                array_push( $array, $params);
            }
        }*/
        return $array ;
    }

}