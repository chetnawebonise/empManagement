<?php
class Emp
{
    private $dbConn;

    public function __construct(Db $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    public function addEmp($emp)
    {
        return $this->dbConn->insert('employees', $emp);
    }

    public function viewEmp()
    {
        return $this->dbConn->selectQuery('employees');
    }

    public function showEmp()
    {
        $query = 'SELECT *,s.fromDate AS salFromDate, s.toDate AS salToDate, dm.managerId AS dmManagerId, dm.fromDate AS dmFromDate, dm.toDate AS dmToDate, et.fromDate AS jobFromDate, et.toDate AS jobToDate FROM employees AS e LEFT JOIN department_employees AS de ON e.id = de.empId  LEFT JOIN  employees_titles AS et ON e.id = et.empId LEFT JOIN  salaries AS s ON e.id = s.empId LEFT JOIN  department_managers AS dm ON e.id = dm.managerId';
        return $this->dbConn->customQuery($query);
    }

    public function viewEmpManager()
    {
        $query = 'SELECT * FROM employees as e where managerId IS NOT NULL';
        return $this->dbConn->customQuery($query);
    }

    public function deleteEmp($id)
    {
        return $this->dbConn->deleteQuery('employees', $id);
    }

    public function editEmp($params, $where)
    {
        return $this->dbConn->updateQuery('employees', $params, $where);
    }

    public function addDeptEmp($params)
    {
        return $this->dbConn->insert('department_employees', $params);
    }

    public function addDeptManager($params)
    {
        return $this->dbConn->insert('department_managers', $params);
    }

    public function addEmpJobTitle($params)
    {
        return $this->dbConn->insert('employees_titles', $params);
    }

    public function addSalaries($params)
    {
        return $this->dbConn->insert('salaries', $params);
    }

    public function viewEmpExcel()
    {
        $query = 'CALL sp_empInfo';
        return $this->dbConn->customQuery($query);
    }
}