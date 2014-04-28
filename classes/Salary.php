<?php
class Salary
{
    private $dbConn;

    public function __construct(Db $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    public function addSalary($dept)
    {
        return $this->dbConn->insert('salaries', $dept);
    }

    public function viewSalary()
    {
        $query = 'SELECT s.`id`,s.`empId`, s.`fromDate`, s.`toDate`, s.`salary`, e.`empName` FROM salaries AS s LEFT JOIN employees AS e ON s.`empId`=e.`id`';
        return $this->dbConn->customQuery($query);
    }

    public function deleteSalary($id)
    {
        return $this->dbConn->deleteQuery('salaries', $id);
    }

    public function editSalary($params, $where)
    {
        return $this->dbConn->updateQuery('salaries', $params, $where);
    }
}