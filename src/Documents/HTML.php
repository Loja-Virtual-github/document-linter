<?php

namespace LojaVirtual\DocumentLinter\Documents;

/**
 * HTML Linter
 */
class HTML extends AbstractLinter implements LinterInteface
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var bool
     */
    protected $rawDocument;

    /**
     * Constructor
     *
     * @param string    $content
     * @param bool      $rawDocument
     * @throws \InvalidArgumentException
     */
    public function __construct($content, $rawDocument = false)
    {
        if (empty($content)) {
            throw new \InvalidArgumentException("Content cannot be empty.");
        }

        $this->content = $content;
        $this->rawDocument = $rawDocument;
        $this->execute(parent::extractLinterName(self::class));
    }

    /**
     * Wrap a content in a whole HTML
     *
     * @param $html
     * @return string
     */
    public static function wrapHTML($html)
    {
        return "
            <!DOCTYPE html>
            <html>
            <head>
                <title>HTML Linter</title>
            </head>
            <body>
                $html
            </body>
            </html>
        ";
    }

    /**
     * Return the content to check
     *
     * @return string
     */
    protected function getContent()
    {
        if (!$this->rawDocument) {
            return self::wrapHTML($this->content);
        }

        return $this->content;
    }
}