<?php

namespace App\Command;

use App\Entity\User;
use App\Service\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Helper\SymfonyQuestionHelper;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[AsCommand(
    name: 'app:add-user',
    description: 'Add a short description for your command',
)]
class AddUserCommand extends Command
{
    // private $entityManager;
    // private $passwordEncoder;

    // public function __construct(private UserManager $userManager)
    // {
    //     parent::__construct();
    // }

    // protected function configure(): void
    // {
    //     $this
    //         ->setName('app:add-user')
    //         ->setDescription('Add a new user')
    //         ->addArgument('email', InputArgument::REQUIRED, 'your Email :')
    //         ->addArgument('password', InputArgument::REQUIRED, 'your Password :')
    //     ;
    // }

    // protected function execute(InputInterface $input, OutputInterface $output, UserPasswordHasherInterface $passwordHasher): int
    // {
    //     $this->userManager->create($input->getArgument('email'), $input->getArgument('password'), $passwordHasher);

    //     $output->writeln('User added successfully.');

    //     return Command::SUCCESS;
    // }
}
