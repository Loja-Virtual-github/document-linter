<?php

namespace PabloSanches\DocumentLinter\Documents;

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
     * @param string    $content
     * @param bool      $rawDocument
     * @throws \InvalidArgumentException
     */
    public function __construct($content)
    {
        if (empty($content)) {
            throw new \InvalidArgumentException("Content cannot be empty.");
        }

        $this->content = $content;
        $this->execute(parent::extractLinterName(self::class));
    }

    /**
     * Return the content to check
     *
     * @return string
     */
    protected function getContent()
    {
        return $this->content;
    }
}