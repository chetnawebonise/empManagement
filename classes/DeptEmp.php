<?php
class DeptEmp
{
    private $dbConn;

    public function __construct(Db $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    public function addDeptEmp($dept)
    {
        return $this->dbConn->insert('department_employees', $dept);
    }

    public function viewDeptEmp()
    {
        $query = 'select de.id, de.departmentId as deptId, d.deptName as deptName, de.empId, e.empName as empName from department_employees as de left join departments as d on de.departmentId = d.id left join employees as e on de.empId = e.id';
        return $this->dbConn->customQuery($query);
    }

    public function deleteDeptEmp($id)
    {
        return $this->dbConn->deleteQuery('department_employees', $id);
    }

    public function editDeptEmp($params, $where)
    {
        return $this->dbConn->updateQuery('department_employees', $params, $where);
    }
}