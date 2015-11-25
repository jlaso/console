<?php

include_once __DIR__ . '/../vendor/autoload.php';

use JLaso\Console as JLasoConsole;

$options = JLasoConsole\ArgumentsHelper::getInstance()
    ->addHelpOption()
    ->addOption("verbose", JLasoConsole\ConsoleOptionType::NO_ARG(), "Verbosity")
    ->addOption("env", JLasoConsole\ConsoleOptionType::OPTIONAL(), "Environment", "dev")->setAlternatives(array("dev", "prod"))
    ->bind($help = true);

echo "The 'env' argument is " . $options['env'] . "\n";
echo isset($options['verbose']) ? "You have add 'verbose' argument\n" : "";
