<?php

namespace App\Command;

use App\Services\SaveArticle;
use App\Services\SaveArticleNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;

class Parser extends Command
{    
    private $savearticle;
    public $em;
    public function __construct(SaveArticle $savearticle, MessageBusInterface $bus)
    {
        $this->log = $savearticle;
        $this->bus = $bus;

        // you *must* call the parent constructor
        parent::__construct();
    }

    // In this function set the name, description and help hint for the command
    protected function configure(): void
    {
        // Use in-build functions to set name, description and help

        $this->setName('run-parser')
            ->setDescription('This command runs your custom task')
            ->setHelp('Run this command to execute your custom tasks in the execute function.');
    }

    // write the code you want to execute when command runs
    protected function execute(InputInterface $input, OutputInterface $output)
    {        
        $this->bus->dispatch(new SaveArticleNotification($this->log->saveArticle())) ;        
        return Command::SUCCESS;

    }
    
}