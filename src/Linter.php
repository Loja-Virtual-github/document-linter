<?php

namespace PabloSanches\DocumentLinter;

use PabloSanches\DocumentLinter\Documents\LinterInteface;

/**
 * Linter
 */
final class Linter
{
    /**
     * Build the linter class name
     *
     * @param $className
     * @return string
     */
    private static function buildLinterClassName($className)
    {
        return __NAMESPACE__ . "\\Documents\\$className";
    }

    /**
     * Create a linter class
     *
     * @param $linterName
     * @param array $arguments
     * @throws LinterException
     * @return LinterInteface
     */
    public static function __callStatic($linterName, array $arguments)
    {
        $className = self::buildLinterClassName($linterName);

        if (!class_exists($className)) {
            throw new LinterException("Class $linterName does not exists.");
        }

        return new $className($arguments[0], $arguments[1]);
    }
}