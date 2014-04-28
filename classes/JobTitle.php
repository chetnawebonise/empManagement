<?php
class JobTitle
{
    private $dbConn;

    public function __construct(Db $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    public function addJobTitle($jobTitle)
    {
        return $this->dbConn->insert('job_titles', $jobTitle);
    }

    public function viewJobTitle()
    {
        return $this->dbConn->selectQuery('job_titles');
    }

    public function deleteJobTitle($id)
    {
        return $this->dbConn->deleteQuery('job_titles', $id);
    }

    public function editJobTitle($params, $where)
    {
        return $this->dbConn->updateQuery('job_titles', $params, $where);
    }
}