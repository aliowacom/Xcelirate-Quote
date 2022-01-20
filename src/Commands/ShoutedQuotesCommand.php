<?php

declare(strict_types=1);

namespace XcelirateQuote\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use XcelirateQuote\QuoteApi\Quote\Application\ShoutedQuotesService;

class ShoutedQuotesCommand extends Command
{
    protected static $defaultName = 'app:shouted-quotes';
    protected static $defaultDescription = 'Retrieve SHOUTED quotes from external source';

    public function __construct(ShoutedQuotesService $service)
    {
        $this->service = $service;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('author', InputArgument::REQUIRED, 'Enter quotes author (e.g. Bill Gates).')
            ->addArgument('amount', InputArgument::REQUIRED, 'Enter quote amount (1 to 10).')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $author = $input->getArgument('author');
        $amount = $input->getArgument('amount');

        $output->writeln(sprintf('Requesting %s, quote(s) of %s...', $amount, $author));

        try {
            $quotes = $this->service->__invoke($author, $amount);
            $output->writeln(sprintf('Found %s, quote(s) of %s', count($quotes), $author));
            $output->writeln($quotes);

            return Command::SUCCESS;

        } catch(\Exception $e) {
            $output->writeln('ERROR');
            $output->writeln($e->getMessage());

            return Command::FAILURE;
        }
    }
}