<?php

namespace PabloSanches\DocumentLinter;

use GuzzleHttp\Psr7\Response;

interface LinterInteface
{
    public function isValid();
    public function getFieldMapping();
}