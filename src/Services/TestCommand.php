<?php

namespace App\Services;

use App\Repository\CalendarRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command {
private $repository;

public function  __construct(string $name = null,CalendarRepository $repository)
{
    $this->repository = $repository;
    parent::__construct($name);
}

    protected function configure () {
        // On set le nom de la commande
        $this->setName('app:test');

        // On set la description
        $this->setDescription("Permet juste de faire un test dans la console");

        // On set l'aide
        $this->setHelp("Je serai affiche si on lance la commande app/console app:test -h");

        // On prépare les arguments
       /* $this->addArgument('name', InputArgument::REQUIRED, "Quel est ton prenom ?")
            ->addArgument('last_name', InputArgument::OPTIONAL, "Quel est ton nom ?");*/
    }

    public function execute (InputInterface $input, OutputInterface $output) {


        $lignes = $this->repository->findAll();

      /*  $text = 'Hi '.$input->getArgument('name');

        $lastName = $input->getArgument('last_name');
        if ($lastName) {
            $text .= ' '.$lastName;
        }*/
dd($lignes);
        $output->writeln("text".'!');
    }
}