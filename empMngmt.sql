/*
SQLyog Ultimate v11.11 (32 bit)
MySQL - 5.5.35-0ubuntu0.12.04.2 : Database - emp_management
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`emp_management` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `emp_management`;

/*Table structure for table `department_employees` */

DROP TABLE IF EXISTS `department_employees`;

CREATE TABLE `department_employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empId` int(11) NOT NULL,
  `departmentId` int(11) DEFAULT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `createdOn` datetime NOT NULL,
  `modifiedOn` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `department_employees` */

insert  into `department_employees`(`id`,`empId`,`departmentId`,`fromDate`,`toDate`,`createdOn`,`modifiedOn`) values (1,1,1,'0000-00-00','0000-00-00','2014-04-28 14:48:39','0000-00-00 00:00:00');

/*Table structure for table `department_managers` */

DROP TABLE IF EXISTS `department_managers`;

CREATE TABLE `department_managers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `managerId` int(11) NOT NULL,
  `departmentId` int(11) NOT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `createdOn` datetime NOT NULL,
  `modifiedOn` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `managerId` (`managerId`),
  CONSTRAINT `department_managers_ibfk_1` FOREIGN KEY (`managerId`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `department_managers` */

/*Table structure for table `departments` */

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deptName` varchar(100) NOT NULL,
  `createdOn` datetime NOT NULL,
  `modifiedOn` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `departments` */

insert  into `departments`(`id`,`deptName`,`createdOn`,`modifiedOn`) values (1,'SMT','2014-04-25 15:10:51',NULL);

/*Table structure for table `employees` */

DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empName` varchar(100) NOT NULL,
  `managerId` int(11) DEFAULT NULL,
  `dob` date NOT NULL,
  `gender` enum('M','F') DEFAULT NULL,
  `hireDate` date NOT NULL,
  `createdOn` datetime NOT NULL,
  `modifiedOn` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `managerId` (`managerId`),
  CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`managerId`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `employees` */

insert  into `employees`(`id`,`empName`,`managerId`,`dob`,`gender`,`hireDate`,`createdOn`,`modifiedOn`) values (1,'chetna',NULL,'2014-03-14','M','2014-04-14','2014-04-25 15:18:52','2014-04-25 15:19:52'),(2,'chetna2',NULL,'2014-04-14','F','2014-04-01','2014-04-28 15:38:33','0000-00-00 00:00:00');

/*Table structure for table `employees_titles` */

DROP TABLE IF EXISTS `employees_titles`;

CREATE TABLE `employees_titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empId` int(11) NOT NULL,
  `jobTitleId` int(11) DEFAULT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `createdOn` datetime NOT NULL,
  `modifiedOn` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `empId` (`empId`),
  KEY `jobTitleId` (`jobTitleId`),
  CONSTRAINT `employees_titles_ibfk_1` FOREIGN KEY (`empId`) REFERENCES `employees` (`id`),
  CONSTRAINT `employees_titles_ibfk_2` FOREIGN KEY (`jobTitleId`) REFERENCES `job_titles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `employees_titles` */

insert  into `employees_titles`(`id`,`empId`,`jobTitleId`,`fromDate`,`toDate`,`createdOn`,`modifiedOn`) values (1,1,1,'2014-04-28','2014-04-28','2014-04-28 12:11:45','2014-04-28 14:53:24'),(2,1,2,'2014-03-01','2014-03-31','2014-04-28 14:54:06','2014-04-28 16:08:49'),(3,2,1,'2014-04-01','2014-04-30','2014-04-28 15:39:03','0000-00-00 00:00:00'),(4,2,1,'2014-03-01','2014-03-31','2014-04-28 15:39:12','0000-00-00 00:00:00');

/*Table structure for table `job_titles` */

DROP TABLE IF EXISTS `job_titles`;

CREATE TABLE `job_titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `createdOn` datetime NOT NULL,
  `modifiedOn` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `job_titles` */

insert  into `job_titles`(`id`,`title`,`createdOn`,`modifiedOn`) values (1,'PHP Dev','2014-04-25 15:11:00','0000-00-00 00:00:00'),(2,'PHP Dev1','2014-04-28 14:41:42','2014-04-28 16:08:42');

/*Table structure for table `salaries` */

DROP TABLE IF EXISTS `salaries`;

CREATE TABLE `salaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empId` int(11) NOT NULL,
  `salary` int(11) DEFAULT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `createdOn` datetime NOT NULL,
  `modifiedOn` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `empId` (`empId`),
  CONSTRAINT `salaries_ibfk_1` FOREIGN KEY (`empId`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `salaries` */

insert  into `salaries`(`id`,`empId`,`salary`,`fromDate`,`toDate`,`createdOn`,`modifiedOn`) values (1,1,100,'2014-04-01','2014-04-22','2014-04-28 14:43:14','0000-00-00 00:00:00'),(2,1,50,'2014-03-01','2014-04-30','2014-04-28 16:19:05','0000-00-00 00:00:00');

/* Procedure structure for procedure `sp_empInfo` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_empInfo` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_empInfo`()
BEGIN
SELECT e.id AS empId, e.empName, e.hireDate, e.gender, e.dob
#, s.salary
, de2.deptName
, t.title
, jt4.title AS lastTitle, jt4.fromDate, jt4.toDate
, s5.salary AS lastSal, ((s5.salary/s6.salary) * 100) AS salPercentage
FROM employees AS e LEFT JOIN employees AS em ON e.id = em.managerId 
#LEFT JOIN salaries AS s ON e.id = s.empId 
LEFT JOIN (SELECT d.deptName, de.* FROM departments AS d LEFT JOIN department_employees AS de ON d.id = de.departmentId) AS de2 ON e.id = de2.empId
LEFT JOIN (SELECT et.*, jt.title FROM employees_titles AS et LEFT JOIN job_titles AS jt ON et.jobTitleId = jt.id HAVING CURDATE() BETWEEN et.fromDate AND et.toDate) AS t ON e.id = t.empId
LEFT JOIN (SELECT * FROM (SELECT l.id AS lId, l.empId, l.jobTitleId, l.fromDate AS fromDate, l.toDate AS toDate FROM `employees_titles` AS l LEFT JOIN `employees_titles` AS r ON l.empId = r.empId WHERE l.`fromDate` < r.`fromDate`) AS emp LEFT JOIN `job_titles` AS jt1 ON emp.`jobTitleId` = jt1.id) AS jt4 ON jt4.empId = e.id
LEFT JOIN (SELECT * FROM salaries ORDER BY salary DESC LIMIT 1 , 1) AS s5 ON e.`id` = s5.empId
LEFT JOIN (SELECT * FROM salaries ORDER BY salary DESC LIMIT 1) AS s6 ON s5.id = s6.id;
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
