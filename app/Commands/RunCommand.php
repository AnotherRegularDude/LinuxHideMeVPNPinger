<?php

namespace App\Commands;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class, that handle all logick for default command.
 */
class RunCommand
{
    private $_defaultFilePath;


    /**
     * Set configs with scalar values from DI.
     *
     * @param $defaultFilePath Path to default ovpn settings file.
     *
     * @Inject({"settings.pathToFile"})
     */
    public function setDefaultConfigs(string $defaultFilePath)
    {
        $this->_defaultFilePath = $defaultFilePath;

    }//end setDefaultConfigs()


    public function execute(OutputInterface $output)
    {
        $output->writeln($this->_defaultFilePath);

    }//end execute()


}//end class
