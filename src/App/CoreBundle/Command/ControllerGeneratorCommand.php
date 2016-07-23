<?php
namespace App\CoreBundle\Command;

use App\CoreBundle\Services\Utils;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;


class ControllerGeneratorCommand extends ContainerAwareCommand
{
    private $bundles = [];

    protected function configure()
    {
        $this->setName('mywebsite:generate-controller')
            ->setDefinition(array(
                new InputOption('controller', null, InputOption::VALUE_REQUIRED, 'Le nom du controller à créer'),
                new InputOption('bundle', null, InputOption::VALUE_REQUIRED, 'Le bundle dans lequel créer le controller'),
                new InputOption('baseController', null, InputOption::VALUE_REQUIRED, 'S\'il faut ou non heriter du controller de base de Symfony2')
            ))
            ->setDescription('Genere le code de base pour commencer a utiliser un controller')
            ->setHelp('Cette commande vous permet de facilement generer le code necessaire pour commencer a travailler avec un controller.');

    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $this->getBundles();

        // On affiche quelques infos
        $dialog = $this->getHelper('question');
        $output->writeln(array(
            '',
            '      Bienvenue dans le générateur de controllers',
            '',
            'Cet outil va vous permettre de générer rapidement votre controller',
            '',
        ));

        // On récupère les informations de l'utilisateur
        $controllerQuestion = new Question('Nom du controller: ');
        $controllerQuestion->setValidator(function ($answer) {
            if (empty($answer)) {
                throw new \RuntimeException(
                    'The name of the controller cannot be blank'
                );
            }
            if (!preg_match('/^[A-Z]{1}[a-z]+/', $answer)) {
                throw new \RuntimeException(
                    'The name of the controller should have a upper first character'
                );
            }
            return $answer;
        });
        $controller = $dialog->ask($input, $output, $controllerQuestion);

        $baseControllerQuestion = new ChoiceQuestion(
            'Voulez vous que le bundle étende le controller de base de Symfony2(yes) ?',
            array('yes', 'no'),
            '0'
        );
        $baseControllerQuestion->setErrorMessage('%s is invalid.');
        $baseController = $dialog->ask($input, $output, $baseControllerQuestion);

        $question = new Question ('bundle: ');
        $question->setAutocompleterValues($this->bundles);
        $question->setValidator(function ($answer) {
            if (!in_array($answer, $this->bundles)) {
                throw new \RuntimeException(
                    'The name of the bundle is incorrect'
                );
            }
            return $answer;
        });
        $bundleName = $dialog->ask(
            $input,
            $output,
            $question
        );

        // On sauvegarde les paramètres
        $input->setOption('controller', $controller);
        $input->setOption('baseController', $baseController);
        $input->setOption('bundle', $bundleName);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelper('question');

        $question = new ConfirmationQuestion('Do you confirm generation(yes)?', true);

        if (!$dialog->ask($input, $output, $question)) {
            $output->writeln('<error>Command aborted</error>');
            return;
        }

        // On recupere les options
        $controller = $input->getOption('controller');
        $baseController = $input->getOption('baseController');
        $bundleName = $input->getOption('bundle');

        // On recupere les infos sur le bundle nécessaire à la génération du controller
        $kernel = $this->getContainer()->get('kernel');
        $bundle = $kernel->getBundle($bundleName);
        $namespace = $bundle->getNamespace();
        $path = $bundle->getPath();
        $target = $path . '/Controller/' . $controller . 'Controller.php';

        // On génère le contenu du controleur
        $twig = $this->getContainer()->get('templating');

        $controller_code = $twig->render('controllerCommand/controller.php.twig',
            array(
                'controller' => $controller,
                'baseController' => $baseController,
                'namespace' => $namespace
            )
        );

        // On crée le fichier
        if (!is_dir(dirname($target))) {
            mkdir(dirname($target), 0777, true);
        }
        file_put_contents($target, $controller_code);

        $logger = $this->getContainer()->get('logger');

        $logger->debug('This is a debug message');
        $logger->info('This is an info message');
        $logger->notice('This is an notice message');
        $logger->warning('This is a warning message');
        $logger->error('This is an error message');
        $logger->critical('This is a critical message');
        $logger->alert('This is an alert message');
        $logger->emergency('This is an emergency message');

        return 0;
    }

    private function getBundles()
    {
        $utils = new Utils();
        $bundles = $utils->getBundlesList();

        foreach ($bundles as $bundle) {
            array_push($this->bundles, 'App' . $bundle);
        }
    }
}