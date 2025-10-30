<?php

namespace src\Core;

use src\Util\Template;

class TemplateController {

    protected Template $template;

    public function __construct(string $diretorio) {
        $this->template = new Template($diretorio);
    }
}