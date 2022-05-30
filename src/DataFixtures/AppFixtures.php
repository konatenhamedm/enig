<?php

namespace App\DataFixtures;

use App\Entity\Groupe;
use App\Entity\Icons;
use App\Entity\Module;
use App\Entity\ModuleParent;
use App\Entity\User;
use App\Repository\ModuleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $module;
    private $encode;

    public function __construct(ModuleRepository $repository, UserPasswordHasherInterface $encode)
    {
        $this->module = $repository->find(17);
        $this->encode = $encode;

    }

    public function load(ObjectManager $manager): void
    {

        $array = [
            "1"=>"fe-home",
            "2"=> "fe-slack",
             "3"=>"fe-layers",
             "4"=>"fe-shopping-bag",
             "5"=>"fe-users",
             "6"=>"fe-chevron-right",
             "7"=>"fe-grid",
             "8"=>"fe-send",
             "9"=>"fe-map-pin",
             "10"=>"fe-bar-chart-2",
             "11"=>"fe-settings",
             "12"=>"fe-mail",
             "13"=>"fe-book-open",
        ];

        foreach ($array as $e){
        $icon = new Icons();
        $icon->setCode($e);
        $icon->setImage("");
        $icon->setActive(1);
        $manager->persist($icon);

    }


        $icon1 = new Icons();
        $icon1->setCode("tio-apps");
        $icon1->setImage("");
        $icon1->setActive(1);
        $manager->persist($icon1);

        $parent = new ModuleParent();
        $parent->setTitre('PARAMETRAGES');
        $parent->setOrdre(1);
        $parent->setActive(1);
        $manager->persist($parent);

        $mod2 = new Module();
        $mod2->setTitre('Paramétrage')
            ->setOrdre(1)
            ->setActive(1)
            ->setIcon($icon)
            ->setParent($parent);
        $manager->persist($mod2);

        $groupe6 = new Groupe();
        $groupe6->setIcon($icon1)
            ->setLien('module')
            ->setModule($mod2)
            ->setOrdre(1)
            ->setTitre('Les modules');
        $manager->persist($groupe6);

        $groupe7 = new Groupe();
        $groupe7->setIcon($icon1)
            ->setLien('parent')
            ->setModule($mod2)
            ->setOrdre(2)
            ->setTitre("Les parents");
        $manager->persist($groupe7);

        $parent1 = new ModuleParent();
        $parent1->setTitre('ENIG');
        $parent1->setOrdre(2);
        $parent1->setActive(1);
        $manager->persist($parent1);

        $mod = new Module();
        $mod->setTitre('Gestions produits')
            ->setOrdre(1)
            ->setActive(1)
            ->setIcon($icon)
            ->setParent($parent1);
        $manager->persist($mod);

        $groupe44 = new Groupe();
        $groupe44->setIcon($icon1)
            ->setLien('categorie')
            ->setModule($mod)
            ->setOrdre(1)
            ->setTitre("Les catégories");
        $manager->persist($groupe44);

        $groupe = new Groupe();
        $groupe->setIcon($icon1)
            ->setLien('produit')
            ->setModule($mod)
            ->setOrdre(1)
            ->setTitre("Les produits");
        $manager->persist($groupe);





        $user1 = new User();
        $password = "bekanty";
        $user1->setPassword($this->encode->hashPassword($user1, $password));
        $user1->setActive(1);
        $user1->setNom("Bekanty");
        $user1->setPrenoms("Bekanty");
        $user1->setEmail("bekanty@gmail.com");
        $manager->persist($user1);








 /*       $groupe3 = new Groupe();
        $groupe3->setIcon($icon1)
            ->setLien('type')
            ->setModule($mod2)
            ->setOrdre(1)
            ->setTitre('TypeActe acte');
        $manager->persist($groupe3);*/



          $user = new User();

          $user->setNom('Konate')
              ->setemail('konatenhamed@gmail.com')
              ->setPrenoms('Hamed')
              ->setPassword($this->encode->hashPassword($user, "konate"))
              ->setActive(1);
        $manager->persist($user);
        /*  $mod = new Module();
          for ($i = 1; $i <= 2000; $i++) {
           $group[$i] = new Groupe();
           $group[$i]->setIcon("menu-bullet menu-bullet-line");
              $group[$i]->setOrdre(1);
              $group[$i]->setLien('parent');
             // $group[$i]->setModule($mod);
              $group[$i]->setTitre('parent');
              $manager->persist($group[$i]);
          }*/


        // $manager->persist($user);

        $manager->flush();
    }
}
