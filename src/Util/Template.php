<?php

namespace src\Util;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Lexer;
use Twig\TwigFunction;
use src\Core\Helpers;

class Template {

    protected Environment $twig;

    public function __construct(string $diretorio) {
        
        $loader = new FilesystemLoader($diretorio);

        $this->twig = new Environment($loader);

        $lexer = new Lexer($this->twig, array(
            $this->helpers()
        ));

        $this->twig->setLexer($lexer);
    }

    /**
     * @param string $view - nome do site ou template a ser renderizado
     * @param array $dados - array de dados a serem enviados para a view, site ou template
     * @return string 
     */
    public function renderizar($view, $dados): string  {
        return $this->twig->render($view, $dados);
    }


    // Criacao de funcoes para usar no twig
    public function helpers(): void { 
        array(
            // Criando funcao url do Helpers
            $this->twig->addFunction(
                new TwigFunction('url', function(string $url = null){
                        return Helpers::url($url);
                    }
                )
            ),
            // Criando funcao resumirTexto da classe Helpers            
            $this->twig->addFunction(
                new TwigFunction('resumirTexto', function(string $texto, int $limitePalavras){
                        return Helpers::resumirTexto($texto, $limitePalavras);
                    }
                )
            )
        );
    }

}