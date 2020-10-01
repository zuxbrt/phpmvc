<?php

namespace core\Console;

use core\Database\Manager;

class Commands
{
    /**
     * Registered commands.
     */
    protected $registered_commands = [
        "database:setup",
        //"database:check",
        "database:clear",
        "--help"
    ];


    /**
     * Info messages for commands.
     */
    protected $messages = [
        'unknown_command' => 'Unknown command. Run php cli --help for more info.',
        '--help' => [
            'Available commands: ' => [
                'database:setup'    => 'Create database tables.',
                'database:clear'    => 'Drop tables from database.',
                //'database:check'    => 'In progress',
                '--help        '    => 'Show available commands'
            ] 
        ]
    ];


    /**
     * Execute commands passed from command line.
     * @param array $arguments
     */
    public function run(array $arguments)
    {
        // make sure first argument is cli
        if($arguments[0] == 'cli'){
            if(count($arguments) > 1){
                if($arguments[1] == '--help'){
                    return $this->echoMessage($this->messages['--help']);
                }
                array_shift($arguments);
                return $this->echoMessage($this->executeCommands($arguments));
            }
        } 

        return $this->echoMessage($this->messages['unknown_command']);
    }


    /**
     * Execute registered command according to its assigned action.
     * @param array $commands
     */
    protected function executeCommands(array $commands)
    {
        $dbManager = new Manager();

        if(in_array($commands[0], $this->registered_commands)){
            switch ($commands[0]) {
                case 'database:setup':
                    return $dbManager->setupDatabase();
                    break;
                
                case 'database:clear':
                    return $dbManager->clearDatabase();
                    break;
                default:
                    # code...
                    break;
            }
        }
        return $this->echoMessage($this->messages['unknown_command']);
    }


    /**
     * Echo message.
     * @param string $message
     */
    protected function echoMessage($message)
    {
        if(is_array($message)){
            foreach($message as $key => $val){

                if(is_string($key)){
                    echo $key.PHP_EOL;
                }

                if(is_string($val)){
                    echo $val.PHP_EOL;
                } else {
                    if(is_array($val)){
                        foreach($val as $comm => $info){
                            echo "* ".$comm." \t ".$info.PHP_EOL;
                        }
                    } else {
                        die($val);
                    }
                }
            }
        } else {
            echo PHP_EOL.$message.PHP_EOL;
        }
    }
}