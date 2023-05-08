<?php

namespace Config;

use PDO;

class Database {

    private $conn;
    private $tableName;

    // Para configurar a conexão com o banco de dados, basta mudar os valores das variáveis abaixo
    private $dbName     = "teste_softexpert";
    private $userName   = "postgres";
    private $password   = "postgres";

    public function __construct () 
    {
        self::setConn(new PDO("pgsql:host=127.0.0.1;dbname=" . $this->dbName, $this->userName, $this->password));
    }

    /**
     * Método para inserir no banco de dados
     *
     * @param array $_campo
     * @return boolean
     */
    public function insert($_campo, $returninId = false) 
    {
        // pega os nomes dos campos
        $parameter_label   = implode(', ', array_keys($_campo) );
        
        //gera os '?' para colocar na query
        $parameter_fill    = implode( ', ', array_fill( 1, count($_campo), '?' ) );

        //monta a query
        $sql = "INSERT INTO " . self::getTableName() . " (" . $parameter_label . ") VALUES (" . $parameter_fill . ") " . ($returninId ? ' RETURNING id' : '') . ';';

        //prepara a query
        $query = self::getConn()->prepare($sql);

        $count = 0;

        //adiciona os parâmetros 
        foreach($_campo as $key => $item) 
        {
            $query->bindParam( ++$count, $_campo[$key] );
        }

        //retorna se a query funcionou
        if(!$returninId) {
            return $query->execute();
        } else {
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    /**
     * Método para selecionar dados do banco de dados
     *
     * @param array $_campo
     * @param array $_where
     * @param array $_join
     * @param String $orderBy
     * @param integer $limit
     * @return array
     */
    public function select($_campo, $_where = ['1' => ['condicao' => 'AND', 'comparador' => '=','valor' => 1]], $_join = [], $orderBy = null, $limit = 1000) 
    {
        $campo  = implode(', ', $_campo);
        $join   = implode(' ', $_join);
        $countWhere = 0;

        $sql    = "SELECT " . $campo . " FROM " . self::getTableName() . " " . $join . " WHERE 1 = 1 ";
        
        foreach($_where as $nome_campo => $_item) 
        {
            $sql.= $_item['condicao'] . ' ' . $nome_campo . ' ' . $_item['comparador'] . ' ? ';
        }

        $sql.= " ORDER BY " . (!is_null($orderBy) ? $orderBy : self::getTableName() . '.id') . ' LIMIT ' . $limit;                
        $rs     = self::getConn()->prepare($sql);

        foreach($_where as $_item) {
            $rs->bindParam(++$countWhere, $_item['valor']);
        }

        $rs->execute();
        $_return = [];

        while($_row = $rs->fetch(PDO::FETCH_ASSOC)) {
            $_return[] = $_row;
        }

        return $_return;
    }

    /**
     * Método para atualizar dados do banco de dados
     *
     * @param array $_campo
     * @param array $_where
     * @return boolean
     */
    public function update($_campo, $_where = ['1' => ['condicao' => 'AND', 'comparador' => '=','valor' => '1']]) 
    {
        $sql = "UPDATE " . self::getTableName() . " SET ";
        $countWhere = 0;

        foreach($_campo as $key => $value) {
            $sql .= $key . " = ?, ";    
        }

        $sql = substr($sql, 0, -2);

        $sql .= " WHERE 1 = 1 ";

        foreach($_where as $nome_campo => $_item) 
        {
            $sql.= $_item['condicao'] . ' ' . $nome_campo . ' ' . $_item['comparador'] . ' ? ';
        }

        $query  = self::getConn()->prepare($sql);

        foreach($_campo as $chave => $value) {
            $query->bindParam( ++$countWhere, $_campo[$chave] );
        }

        foreach($_where as $key => $_item) {
            $query->bindParam(++$countWhere, $_where[$key]['valor']);
        }

        //retorna se a query funcionou
        return $query->execute();
    }


    /**
     * Método para deletar dados do banco de dados
     *
     * @param array $_where
     * @return boolean
     */
    public function delete($_where = ['1' => ['condicao' => 'AND', 'comparador' => '=','valor' => '1']]) 
    {

        $sql = "DELETE FROM " . self::getTableName() . " WHERE 1 = 1 ";
        $countWhere = 0;

        foreach($_where as $nome_campo => $_item) 
        {
            $sql.= $_item['condicao'] . ' ' . $nome_campo . ' ' . $_item['comparador'] . ' ? ';
        }

        $query  = self::getConn()->prepare($sql);

        foreach($_where as $key => $_item) {
            $query->bindParam(++$countWhere, $_where[$key]['valor']);
        }
        
        //retorna se a query funcionou
        return $query->execute();
    }

    /*
    * Getters & Setters
    */

    public function setConn($conn) 
    {
        return $this->conn = $conn;
    }

    public function getConn() 
    {
        return $this->conn;
    }

    public function setTableName($tableName) 
    {
        return $this->tableName = $tableName;
    }

    public function getTableName() 
    {
        return $this->tableName;
    }

}