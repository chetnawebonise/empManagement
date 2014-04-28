<?php
class Dept
{
    private $dbConn;

    public function __construct(Db $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    public function addDept($dept)
    {
        return $this->dbConn->insert('departments', $dept);
    }

    public function viewDept()
    {
        return $this->dbConn->selectQuery('departments');
    }

    public function deleteDept($id)
    {
        return $this->dbConn->deleteQuery('departments', $id);
    }

    public function editDept($params, $where)
    {
        return $this->dbConn->updateQuery('departments', $params, $where);
    }
}