<?php

class Db
{
    private $username;
    private $password;
    private $dbName;
    private $dbh;

    public function __construct()
    {
        $this->username = 'root';
        $this->password = 'root';
        $this->dbName = 'emp_management';

        try
        {
            $this->dbh = new PDO("mysql:host=localhost;dbname=" . $this->dbName, $this->username, $this->password);
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function selectQuery($tableName, $where = null)
    {
        $query = 'SELECT * FROM ' . $tableName;
        if($where != '')
            $query .= $where;
        $stm = $this->dbh->prepare($query);
        $stm->execute();
        return $stm->fetchAll();
    }

    public function insert($tableName, $params)
    {
        $columns = implode(',', array_keys($params));
        $values = '"' . implode('","', array_values($params)) . '"';
        $columns .= ', createdOn';
        $values .= ', NOW()';
        echo $query = 'INSERT INTO ' . $tableName . ' (' . $columns . ') ' . ' VALUES (' . $values . ')';
        $count = $this->dbh->exec($query);
        return $this->dbh->lastInsertId();
    }

    public function updateQuery($tableName, $params, $where)
    {
        $query = 'UPDATE ' . $tableName . ' SET ';
        foreach($params as $key => $value)
        {
            $query .= $key . '="' . $value . '", ';
        }
        $query .= 'modifiedOn = NOW()';
        $query .= ' where ' . $where;

        $result = $this->dbh->exec($query);

        return $result;
    }

    public function deleteQuery($tableName, $where)
    {
        $query = 'DELETE FROM ' . $tableName;
        $clause = implode(',', array_keys($where)) . '"' . implode('","', array_values($where)) . '"';
        echo $query .= ' where ' . $clause;
    }

    public function customQuery($query)
    {
        $stm = $this->dbh->prepare($query);
        $stm->execute();
        return $stm->fetchAll();
    }
}