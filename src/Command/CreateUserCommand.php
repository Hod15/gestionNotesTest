<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class CreateUserCommand extends Command
{
    protected static $defaultName = 'user:create';

    private $entityManager;
    private $passwordEncoder;


    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:user:create')
            ->setDescription("Create User")
            ->setDefinition([
                new InputArgument('email', InputArgument::REQUIRED, 'The email'),
                new InputArgument('firstname', InputArgument::REQUIRED, 'First Name'),
                new InputArgument('lastname', InputArgument::REQUIRED, 'Last Name'),
                new InputArgument('password', InputArgument::REQUIRED, 'The password'),
                new InputOption('super-admin', null, InputOption::VALUE_NONE, 'Set the user as super admin'),
                new InputOption('inactive', null, InputOption::VALUE_NONE, 'Set the user as inactive'),
            ])
            ->setHelp(<<<'EOT'
                The <info>app:user:create</info> command creates a user:
                  <info>php %command.full_name% blaisezogba@gmail.com</info>
                This interactive shell will ask you for an email and then a password.
                You can alternatively specify the email and password as the second and third arguments:
                  <info>php %command.full_name% blaisezogba@gmail.com Blaise ZOGBA mypassword</info>
                You can create a super admin via the super-admin flag:
                  <info>php %command.full_name% blaisezogba@gmail.com --super-admin</info>
                You can create an inactive user (will not be able to log in):
                  <info>php %command.full_name% blaisezogba@gmail.com --inactive</info>
EOT

            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $firstname = $input->getArgument('firstname');
        $lastname = $input->getArgument('lastname');
        $password = $input->getArgument('password');
        $inactive = $input->getOption('inactive');
        $superadmin = $input->getOption('super-admin');

        $this->createUser($email, $password, $firstname, $lastname, !$inactive, $superadmin);

        $output->writeln(sprintf('Created user <comment>%s</comment>', $email));

        return 0;
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questions = [];

        if (!$input->getArgument('email')) {
            $question = new Question('Please choose an email:');
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception('Email can not be empty');
                }

                return $email;
            });
            $questions['email'] = $question;
        }

        if (!$input->getArgument('password')) {
            $question = new Question('Please choose a password:');
            $question->setValidator(function ($password) {
                if (empty($password)) {
                    throw new \Exception('Password can not be empty');
                }

                return $password;
            });
            $question->setHidden(true);
            $questions['password'] = $question;
        }

        if (!$input->getArgument('firstname')) {
            $question = new Question('Please choose a firstname:');
            $question->setValidator(function ($firstname) {
                if (empty($firstname)) {
                    throw new \Exception('Firstname can not be empty');
                }

                return $firstname;
            });
            $questions['firstname'] = $question;
        }

        if (!$input->getArgument('lastname')) {
            $question = new Question('Please choose a lastname:');
            $question->setValidator(function ($lastname) {
                if (empty($lastname)) {
                    throw new \Exception('Lastname can not be empty');
                }

                return $lastname;
            });
            $questions['lastname'] = $question;
        }

        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }

    public function createUser($email, $password, $firstname, $lastname, $active, $superadmin)
    {
        $user = new User();
        $user->setEmail($email);
        $user->setName($firstname);
        $user->setLastName($lastname);
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                $password
            )
        );

        $roles[] = 'ROLE_USER';
        if(((bool) $superadmin)){
            $roles[] = 'ROLE_ADMIN';
        }

        $user->setRoles($roles);
        $user->setLastlogin(new \DateTime());
        $user->setCreatedAt(new \DateTime());
        $user->setModifiedAt(new \DateTime());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}