<?php
class DeptManager
{
    private $dbConn;

    public function __construct(Db $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    public function addDeptManager($dept)
    {
        return $this->dbConn->insert('department_managers', $dept);
    }

    public function viewDeptManager()
    {
        $query = 'SELECT dm.id, dm.departmentId AS deptId, d.deptName AS deptName, dm.managerId, e.empName AS empName FROM department_managers AS dm LEFT JOIN departments AS d ON dm.departmentId = d.id LEFT JOIN employees AS e ON dm.managerId = e.id WHERE e.managerId IS NOT NULL';
        return $this->dbConn->customQuery($query);
    }

    public function deleteDeptManager($id)
    {
        return $this->dbConn->deleteQuery('department_managers', $id);
    }

    public function editDeptManager($params, $where)
    {
        return $this->dbConn->updateQuery('department_managers', $params, $where);
    }
}