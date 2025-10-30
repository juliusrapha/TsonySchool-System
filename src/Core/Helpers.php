<?php

namespace src\Core;

class Helpers {
    
    public static function redirecionar(string $url = null): void
    {
        header('HTTP/1.1 302 Found');
        
        $local = ($url ? self::url($url) : self::url());
        
        header("Location: {$local}");
        
        exit();
    }


    /**
     * Busca informacoes do servidor
     * @return bool
     */
    public static function localhost(): bool {

        $servidor = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_DEFAULT);

        if ($servidor == 'localhost') {
            return true;
        }
        return false;
    }


    /**
     * @param string $url
     * @return string
     */
    public static function url(string $url = null): string {

        $servidor = filter_input(INPUT_SERVER, 'SERVER_NAME');
        $ambiente = ($servidor == 'localhost') ? URL_DESENVOLVIMENTO : URL_PRODUCAO;

        return $ambiente.$url;
    }

    
    public static function resumirTexto($texto, $limitePalavras) 
    {
        $palavras = explode(' ', $texto);
        if (count($palavras) > $limitePalavras) {
            $resumo = array_slice($palavras, 0, $limitePalavras);
            return implode(' ', $resumo) . '...';
        } else {
            return $texto;
        }
    }

}