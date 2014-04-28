SELECT e.id AS empId, em.empName, s.salary, de2.deptName, t.title, e.hireDate, e.gender, e.dob, jt4.title AS lastTitle, jt4.fromDate, jt4.toDate, s5.salary AS lastSal, ((s5.salary/s6.salary) * 100) AS salPercentage
FROM employees AS e LEFT JOIN employees AS em ON e.id = em.managerId 
LEFT JOIN salaries AS s ON e.id = s.empId 
LEFT JOIN (SELECT d.deptName, de.* FROM departments AS d LEFT JOIN department_employees AS de ON d.id = de.departmentId) AS de2 ON e.id = de2.empId
LEFT JOIN (SELECT et.*, jt.title FROM employees_titles AS et LEFT JOIN job_titles AS jt ON et.jobTitleId = jt.id HAVING CURDATE() BETWEEN et.fromDate AND et.toDate) AS t ON e.id = t.empId
LEFT JOIN (SELECT jt3.`title`, et3.`empId`, et3.`fromDate`, et3.`toDate` FROM `employees_titles` AS et3 LEFT JOIN `job_titles` AS jt3 ON et3.`jobTitleId` = jt3.`id` WHERE jt3.id = (SELECT jobTitleId FROM employees_titles AS et2 WHERE et2.fromDate < (SELECT MAX(fromdate) FROM employees_titles) LIMIT 1)) AS jt4 ON e.`id` = jt4.empId
LEFT JOIN (SELECT * FROM salaries ORDER BY salary DESC LIMIT 1 , 1) AS s5 ON e.`id` = s5.empId
LEFT JOIN (SELECT * FROM salaries ORDER BY salary DESC LIMIT 1) AS s6 ON s5.id = s6.id
#last department name remaining

SELECT * FROM employees AS e LEFT JOIN department_employees AS de ON e.id = de.empId  LEFT JOIN  employees_titles AS et ON e.id = et.empId LEFT JOIN  salaries AS s ON e.id = s.empId LEFT JOIN  department_managers AS dm ON e.id = dm.managerId

SELECT *,s.fromDate AS salFromDate, s.toDate AS salToDate, dm.managerId AS dmManagerId, dm.fromDate AS dmFromDate, dm.toDate AS dmToDate, et.fromDate AS jobFromDate, et.toDate AS jobToDate FROM employees AS e LEFT JOIN department_employees AS de ON e.id = de.empId  LEFT JOIN  employees_titles AS et ON e.id = et.empId LEFT JOIN  salaries AS s ON e.id = s.empId LEFT JOIN  department_managers AS dm ON e.id = dm.managerId

SELECT * FROM salaries ORDER BY salary DESC LIMIT 1 , 1

SELECT et.id, et.`empId` AS empId, e.`empName` AS empName, jt.id AS titleId, jt.title AS title FROM employees_titles AS et LEFT JOIN employees AS e ON et.empId = e.id LEFT JOIN job_titles AS jt ON et.jobTitleId = jt.id

SELECT s.`id`,s.`empId`, s.`fromDate`, s.`toDate`, s.`salary`, e.`empName` FROM salaries AS s LEFT JOIN employees AS e ON s.`empId`=e.`id`

SET FOREIGN_KEY_CHECKS=0; TRUNCATE TABLE employees; SET FOREIGN_KEY_CHECKS=1;

DELIMITER$$
CREATE PROCEDURE sp_empInfo()
BEGIN
SELECT e.id AS empId, e.empName, s.salary, de2.deptName, t.title, e.hireDate, e.gender, e.dob, jt4.title AS lastTitle, jt4.fromDate, jt4.toDate, s5.salary AS lastSal, ((s5.salary/s6.salary) * 100) AS salPercentage
FROM employees AS e LEFT JOIN employees AS em ON e.id = em.managerId 
LEFT JOIN salaries AS s ON e.id = s.empId 
LEFT JOIN (SELECT d.deptName, de.* FROM departments AS d LEFT JOIN department_employees AS de ON d.id = de.departmentId) AS de2 ON e.id = de2.empId
LEFT JOIN (SELECT et.*, jt.title FROM employees_titles AS et LEFT JOIN job_titles AS jt ON et.jobTitleId = jt.id HAVING CURDATE() BETWEEN et.fromDate AND et.toDate) AS t ON e.id = t.empId
RIGHT JOIN (SELECT jt3.`title`, et3.`empId`, et3.`fromDate`, et3.`toDate` FROM `employees_titles` AS et3 LEFT JOIN `job_titles` AS jt3 ON et3.`jobTitleId` = jt3.`id` WHERE jt3.id = (SELECT jobTitleId FROM employees_titles AS et2 WHERE et2.fromDate < (SELECT MAX(fromdate) FROM employees_titles) LIMIT 1)) AS jt4 ON e.`id` = jt4.empId
LEFT JOIN (SELECT * FROM salaries ORDER BY salary DESC LIMIT 1 , 1) AS s5 ON e.`id` = s5.empId
LEFT JOIN (SELECT * FROM salaries ORDER BY salary DESC LIMIT 1) AS s6 ON s5.id = s6.id;
END$$
DELIMITER;

CALL sp_empInfo

SELECT e.id AS empId, e.empName, s.salary, de2.deptName, t.title, e.hireDate, e.gender, e.dob, jt4.title AS lastTitle, jt4.fromDate, jt4.toDate, s5.salary AS lastSal, ((s5.salary/s6.salary) * 100) AS salPercentage
FROM employees AS e LEFT JOIN employees AS em ON e.id = em.managerId 
LEFT JOIN salaries AS s ON e.id = s.empId 
LEFT JOIN (SELECT d.deptName, de.* FROM departments AS d LEFT JOIN department_employees AS de ON d.id = de.departmentId) AS de2 ON e.id = de2.empId
LEFT JOIN (SELECT et.*, jt.title FROM employees_titles AS et LEFT JOIN job_titles AS jt ON et.jobTitleId = jt.id HAVING CURDATE() BETWEEN et.fromDate AND et.toDate) AS t ON e.id = t.empId
LEFT JOIN (SELECT * FROM (SELECT l.id AS lId, l.empId, l.jobTitleId, l.fromDate AS fromDate, l.toDate AS toDate FROM `employees_titles` AS l LEFT JOIN `employees_titles` AS r ON l.empId = r.empId WHERE l.`fromDate` < r.`fromDate`) AS emp LEFT JOIN `job_titles` AS jt1 ON emp.`jobTitleId` = jt1.id) AS jt4 ON jt4.empId = e.id
LEFT JOIN (SELECT * FROM salaries ORDER BY salary DESC LIMIT 1 , 1) AS s5 ON e.`id` = s5.empId
LEFT JOIN (SELECT * FROM salaries ORDER BY salary DESC LIMIT 1) AS s6 ON s5.id = s6.id;

SELECT jt3.`title`, et3.`empId`, et3.`fromDate`, et3.`toDate` FROM `employees_titles` AS et3 LEFT JOIN `job_titles` AS jt3 ON et3.`jobTitleId` = jt3.`id` WHERE jt3.id = (SELECT jobTitleId FROM employees_titles AS et2 WHERE et2.fromDate < (SELECT MAX(fromdate) FROM employees_titles) LIMIT 1)


(SELECT jobTitleId FROM employees_titles AS et2 WHERE et2.fromDate < (SELECT MAX(fromdate) FROM employees_titles GROUP BY empId) LIMIT 1)

SELECT * FROM (SELECT * FROM `employees_titles` ORDER BY `fromDate` ASC LIMIT 1,1) AS emp LEFT JOIN `job_titles` AS jt1 ON emp.`jobTitleId` = jt1.id

SELECT * FROM (SELECT l.id AS lId, l.empId, l.jobTitleId, r.jobTitleId AS rFromDate, l.toDate FROM `employees_titles` AS l LEFT JOIN `employees_titles` AS r ON l.empId = r.empId WHERE l.`fromDate` < r.`fromDate`) AS emp LEFT JOIN `job_titles` AS jt1 ON emp.`jobTitleId` = jt1.id