<?php

namespace JLaso\Console;

class ConsoleOption
{
    protected $option;
    protected $type;
    protected $help;
    protected $default;
    protected $alternatives = array();

    /**
     * ConsoleOption constructor.
     * @param string $option
     * @param ConsoleOptionType $type
     * @param string $help
     * @param $default
     */
    public function __construct($option, ConsoleOptionType $type, $help, $default)
    {
        $this->option = $option;
        $this->type = $type;
        $this->help = $help;
        $this->default = $default;
    }

    /**
     * @return string
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * @return ConsoleOptionType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getHelp()
    {
        return $this->help;
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @return null
     */
    public function getAlternatives()
    {
        return $this->alternatives;
    }

    public function hasAlternatives()
    {
        return count($this->alternatives) > 0;
    }

    /**
     * @param $value
     * @return bool
     */
    public function matchAlternative($value)
    {
        return in_array($value, $this->alternatives);
    }

    /**
     * @param null $alternatives
     */
    public function setAlternatives($alternatives)
    {
        $this->alternatives = $alternatives;
    }

}