<?php

namespace JLaso\Console;

class ArgumentsHelper
{
    protected static $instance = null;
    /** @var ConsoleOption[] */
    protected $options;

    /**
     * ArgumentsHelper constructor.
     */
    protected function __construct()
    {
        $this->options = array();
    }


    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function addHelpOption($text = "Shows this help")
    {
        return $this->addOption("help", ConsoleOptionType::NO_ARG(), $text);
    }

    /**
     * @param string $option
     * @param ConsoleOptionType $type
     * @param string $help
     * @param $default
     * @return $this
     */
    public function addOption($option, ConsoleOptionType $type, $help, $default = null)
    {
        $this->options[] = new ConsoleOption($option, $type, $help, $default);

        return $this;
    }

    /**
     * @param array $alternatives
     * @return $this
     */
    public function setAlternatives($alternatives)
    {
        $lastOption = array_pop($this->options);
        $lastOption->setAlternatives($alternatives);
        $this->options[] = $lastOption;

        return $this;
    }

    /**
     * @param bool $help
     * @return array
     * @throws \Exception
     */
    public function bind($help = false)
    {
        $longOpts = array();
        foreach ($this->options as $option) {
            $longOpts[] = $option->getOption() . $option->getType()->getValue();
        }
        $bindValues = getopt("", $longOpts);
        foreach ($this->options as $option) {
            if ($option->getDefault() && !isset($bindValues[$option->getOption()])) {
                $bindValues[$option->getOption()] = $option->getDefault();
            }
            if ($option->getType()->isEqual(ConsoleOptionType::REQUIRED()) && (!isset($bindValues[$option->getOption()]))) {
                throw new \Exception(sprintf("Argument '%s' is required", $option->getOption()));
            }
            if ($option->hasAlternatives() && !$option->matchAlternative($bindValues[$option->getOption()])) {
                throw new \Exception(sprintf(
                    "Value '%s' for argument '%s' doesn't match with alternatives '%s'",
                    $bindValues[$option->getOption()],
                    $option->getOption(),
                    join(",", $option->getAlternatives())
                ));
            }
        }
        if ($help and isset($bindValues['help'])) {
            echo $this->genHelp() . "\n";
            exit();
        }
        return $bindValues;
    }

    /**
     * @return string
     */
    public function genHelp()
    {
        $help = "Help info about the options accepted by this command\n\n";
        foreach ($this->options as $option) {
            $help .= "\t- " . $option->getOption() . ": is " . $option->getType()->getDescription() .
                ($option->getHelp() ? " and represents \"" . $option->getHelp() . "\"" : "") .
                ($option->getDefault() ? " the default value is '" . $option->getDefault() . "'" : "") .
                ($option->hasAlternatives() ? ". The alternatives are '" . join(",", $option->getAlternatives()) . "'" : "") . "\n";
        }
        $help .= "\n";

        return $help;
    }

}