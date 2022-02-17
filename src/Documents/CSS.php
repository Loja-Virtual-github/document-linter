<?php

namespace LojaVirtual\DocumentLinter\Documents;

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
     * @var bool
     */
    protected $dirtyStyle = false;

    /**
     * Constructor
     *
     * @param string    $content
     * @param bool      $rawDocument
     * @throws \InvalidArgumentException
     */
    public function __construct($content, $dirtyStyle = false)
    {
        if (empty($content)) {
            throw new \InvalidArgumentException("Content cannot be empty.");
        }

        $this->content = $content;
        $this->dirtyStyle = $dirtyStyle;
        $this->execute(parent::extractLinterName(self::class));
    }

    /**
     * Return the content to check
     *
     * @return string
     */
    protected function getContent()
    {
        if ($this->dirtyStyle) {
            $this->content = implode(
                "\r\r",
                $this->extractStyleFromHTML($this->content)
            );
        }

        return $this->content;
    }

    /**
     * Extract all content inside a html and return its on an array
     * @param $html
     * @return array
     */
    protected function extractStyleFromHTML($html)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML(HTML::wrapHTML($html));
        $styles = [];
        $stylesNodes = $dom->getElementsByTagName('style');

        if (!empty($stylesNodes)) {
            foreach ($stylesNodes as $styleNode) {
                $styles[] = $styleNode->nodeValue;
            }
        }

        return $styles;
    }
}