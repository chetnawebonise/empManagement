<?php
class EmpTitle
{
    private $dbConn;

    public function __construct(Db $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    public function addEmpTitle($dept)
    {
        return $this->dbConn->insert('employees_titles', $dept);
    }

    public function viewEmpTitle()
    {
        $query = 'SELECT et.id, et.`empId` AS empId, e.`empName` AS empName, jt.id AS titleId, jt.title AS title, et.fromDate, et.toDate FROM employees_titles AS et LEFT JOIN employees AS e ON et.empId = e.id LEFT JOIN job_titles AS jt ON et.jobTitleId = jt.id';
        return $this->dbConn->customQuery($query);
    }

    public function deleteEmpTitle($id)
    {
        return $this->dbConn->deleteQuery('employees_titles', $id);
    }

    public function editEmpTitle($params, $where)
    {
        return $this->dbConn->updateQuery('employees_titles', $params, $where);
    }
}