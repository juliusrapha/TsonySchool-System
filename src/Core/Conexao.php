<?php

namespace src\Core;

use PDO;
use PDOException;

class Conexao {
    
    private static $instancia;
    
    /**
     * Construtor do tipo protegido previne que uma nova instancia 
     * da classe seja criada atraves do operador 'new' de fora da classe
     */
    private function __construct() {
        
    }
    
    /**
     * Metodo de clone do tipo privado previne a clonagem dessa instancia 
     * da classe
     * @param void 
     */
    private function __clone() {
        
    }
    
    public static function getInstance(): PDO {
       
        if (empty(self::$instancia)) {
            
            try {
                
                self::$instancia = new PDO('mysql:host=localhost;dbname=sistema_tsony', 'root', '');
                
            } catch (PDOException $exc) {
                //echo 'ERRO de conexao: '. $exc->getMessage() . '<br />';
                die('ERRO de conexao: '. $exc->getMessage());
            }

        }
        return self::$instancia;
    }
}