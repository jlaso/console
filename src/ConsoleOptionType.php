<?php

namespace JLaso\Console;

use JLaso\Assert\Assert;
use JLaso\Assert\AssertException;

class ConsoleOptionType
{
    const OPTIONAL = "::";
    const REQUIRED = ":";
    const NO_ARG = "";

    protected $value = null;

    /**
     * @param $value
     * @throws AssertException
     */
    public function __construct($value)
    {
        Assert::assertsIsInArray($value, $this->getOptions());
        $this->value = $value;
    }

    /**
     * @return array
     */
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

    /**
     * @return ConsoleOptionType
     */
    public static function OPTIONAL()
    {
        return new static(self::OPTIONAL);
    }

    /**
     * @return ConsoleOptionType
     */
    public static function REQUIRED()
    {
        return new static(self::REQUIRED);
    }

    /**
     * @return ConsoleOptionType
     */
    public static function NO_ARG()
    {
        return new static(self::NO_ARG);
    }
}