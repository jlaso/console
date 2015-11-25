<?php

namespace JLaso\Console;

class ConsoleOptionType
{
    const OPTIONAL = "::";
    const REQUIRED = ":";
    const NO_ARG = "";

    protected $value = null;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public static function getOptions()
    {
        return [
            self::OPTIONAL,
            self::REQUIRED,
            self::NO_ARG,
        ];
    }

    /**
     * @return null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param ConsoleOptionType $type
     * @return bool
     */
    public function isEqual(ConsoleOptionType $type)
    {
        return $type->getValue() == $this->value;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        switch ($this->value) {
            case self::NO_ARG:
                return "an option without arguments";
            case self::OPTIONAL:
                return "optional";
            case self::REQUIRED:
                return "required";
        }

        return "UNKNOWN";
    }

    public static function OPTIONAL()
    {
        return new static(self::OPTIONAL);
    }

    public static function REQUIRED()
    {
        return new static(self::REQUIRED);
    }

    public static function NO_ARG()
    {
        return new static(self::NO_ARG);
    }
}