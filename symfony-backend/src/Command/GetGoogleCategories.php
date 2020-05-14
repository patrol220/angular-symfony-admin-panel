<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetGoogleCategories extends Command
{
    protected static $defaultName = 'app:get-google-categories';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Fills categories with google ones');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        return 0;
    }

}
