<?php

namespace PabloSanches\DocumentLinter;

/**
 * CSS Linter
 */
class CSS extends AbstractLinter implements LinterInteface
{
    /**
     * @var string
     */
    protected $content;

    /**
     * Constructor
     *
     * @param $content
     * @throws \InvalidArgumentException
     */
    public function __construct($content)
    {
        if (empty($content)) {
            throw new \InvalidArgumentException("Content cannot be empty.");
        }

        $this->content = $content;

        parent::__construct();
    }

    /**
     * Returns if a document is valid
     *
     * @return bool
     */
    public function isValid()
    {
        // TODO: Implement validate() method.
        return true;
    }
}