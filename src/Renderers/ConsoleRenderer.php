<?php
namespace ElleHamilton\Glove\Renderers;

use Exception;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleRenderer
{
    /** @var ConsoleApplication */
    private $console;

    /**
     * @param ConsoleApplication $console
     */
    public function __construct(ConsoleApplication $console)
    {
        $this->console = $console;
    }

    /**
     * Render an exception to the console.
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param \Exception                                        $e
     * @return void
     */
    public function render(OutputInterface $output, Exception $e)
    {
        $this->console->renderException($e, $output);
    }
}
