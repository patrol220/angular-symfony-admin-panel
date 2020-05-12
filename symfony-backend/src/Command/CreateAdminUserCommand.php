<?php

namespace App\Command;

use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAdminUserCommand extends Command
{
    protected static $defaultName = 'app:create-admin-user';

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Command for adding admin user')
            ->addArgument('name', InputArgument::REQUIRED, 'Enter user name')
            ->addArgument('email', InputArgument::REQUIRED, 'Enter user email')
            ->addArgument('password', InputArgument::REQUIRED, 'Enter user password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->userService->createNewUser(
            $input->getArgument('name'),
            $input->getArgument('password'),
            $input->getArgument('email')
        );

        return 0;
    }

}
