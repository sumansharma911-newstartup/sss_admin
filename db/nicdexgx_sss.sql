-- Adminer 4.8.1 MySQL 5.5.5-10.4.17-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `department_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `district` tinyint(1) NOT NULL,
  `department_name` varchar(200) NOT NULL,
  `department_address` varchar(200) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `mobile_number` varchar(10) NOT NULL,
  `landline_number` varchar(30) NOT NULL,
  `email` varchar(200) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_time` datetime NOT NULL,
  `updated_by` bigint(20) NOT NULL,
  `updated_time` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `department` (`department_id`, `district`, `department_name`, `department_address`, `pincode`, `mobile_number`, `landline_number`, `email`, `created_by`, `created_time`, `updated_by`, `updated_time`, `is_delete`) VALUES
(1,	1,	'Labour and Employment',	'Labour Department',	'396220',	'',	'',	'lelidaman@gmail.com',	1,	'2020-08-28 13:22:00',	1,	'2022-07-16 11:39:00',	0),
(2,	1,	'Collector Daman',	'',	'',	'',	'',	'',	1,	'2020-08-28 19:25:00',	1,	'0000-00-00 00:00:00',	0),
(3,	1,	'Sub Registrar Daman',	'',	'',	'',	'',	'',	1,	'2020-09-03 14:37:00',	1,	'0000-00-00 00:00:00',	0),
(4,	1,	'Excise Daman',	'',	'',	'',	'',	'',	1,	'2020-09-10 15:02:00',	1,	'2020-09-14 19:25:00',	0),
(5,	1,	'DIC Daman',	'',	'',	'',	'',	'',	1,	'2020-09-10 16:02:00',	1,	'0000-00-00 00:00:00',	0),
(6,	3,	'Collector DNH',	'',	'',	'',	'',	'',	1,	'2020-09-10 16:02:00',	1,	'0000-00-00 00:00:00',	0),
(7,	1,	'PCC Daman',	'',	'',	'',	'',	'',	1,	'2020-09-10 16:03:00',	1,	'0000-00-00 00:00:00',	0),
(8,	3,	'PCC DNH',	'',	'',	'',	'',	'',	1,	'2020-09-10 16:03:00',	1,	'0000-00-00 00:00:00',	0),
(9,	2,	'Sub Registrar Diu',	'',	'',	'',	'',	'',	1,	'2020-09-14 19:14:00',	1,	'0000-00-00 00:00:00',	0),
(10,	3,	'Sub Registrar DNH',	'',	'',	'',	'',	'',	1,	'2020-09-14 19:14:00',	1,	'0000-00-00 00:00:00',	0),
(11,	2,	'Collector Diu',	'',	'',	'',	'',	'',	1,	'2020-09-14 19:15:00',	1,	'0000-00-00 00:00:00',	0),
(13,	1,	'Fire Department Daman',	'',	'',	'',	'',	'',	1,	'2020-09-15 13:13:00',	0,	'0000-00-00 00:00:00',	0),
(14,	3,	'DIC DNH',	'',	'',	'',	'',	'',	1,	'2020-09-18 18:15:00',	1,	'0000-00-00 00:00:00',	0),
(15,	1,	'Transport Daman',	'',	'',	'',	'',	'',	1,	'2020-09-21 10:50:00',	0,	'0000-00-00 00:00:00',	0),
(16,	3,	'Municipal Council Silvassa',	'',	'',	'',	'',	'',	1,	'2020-09-21 10:56:00',	1,	'0000-00-00 00:00:00',	0),
(17,	1,	'Electricity Daman',	'',	'',	'',	'',	'',	1,	'2020-09-21 15:50:00',	0,	'0000-00-00 00:00:00',	0),
(18,	1,	'Weights and Measures Daman',	'',	'',	'',	'',	'',	1,	'2020-09-21 16:24:00',	1,	'2020-09-21 16:35:00',	0),
(19,	1,	'PWD Daman',	'',	'',	'',	'',	'',	1,	'2020-09-21 16:48:00',	1,	'0000-00-00 00:00:00',	0),
(20,	1,	'DIT Daman',	'',	'',	'',	'',	'',	1,	'2020-09-21 17:10:00',	0,	'0000-00-00 00:00:00',	0),
(21,	1,	'Mamlatdar Daman',	'',	'',	'',	'',	'',	1,	'2020-09-30 16:52:00',	1,	'0000-00-00 00:00:00',	0),
(22,	2,	'PWD Diu',	'',	'',	'',	'',	'',	1,	'2020-10-09 20:58:00',	1,	'0000-00-00 00:00:00',	0),
(23,	2,	'Mamlatdar Diu',	'',	'',	'',	'',	'',	1,	'2020-10-09 21:01:00',	1,	'0000-00-00 00:00:00',	0),
(24,	3,	'Mamlatdar DNH',	'',	'',	'',	'',	'',	1,	'2020-10-09 21:04:00',	1,	'0000-00-00 00:00:00',	0),
(25,	1,	'Court Daman',	'',	'',	'',	'',	'',	1,	'2020-10-09 21:08:00',	0,	'0000-00-00 00:00:00',	0),
(26,	1,	'GST Daman',	'',	'',	'',	'',	'',	1,	'2020-10-09 21:11:00',	1,	'0000-00-00 00:00:00',	0),
(27,	1,	'Health Daman',	'',	'',	'',	'',	'',	1,	'2020-10-09 21:16:00',	0,	'0000-00-00 00:00:00',	0),
(28,	1,	'OIDC Daman',	'',	'',	'',	'',	'',	1,	'2020-10-09 21:21:00',	0,	'0000-00-00 00:00:00',	0),
(29,	1,	'Municipal Council Daman',	'',	'',	'',	'',	'',	1,	'2020-10-10 13:31:00',	1,	'0000-00-00 00:00:00',	0),
(30,	2,	'Municipal Council Diu',	'',	'',	'',	'',	'',	1,	'2020-10-10 13:35:00',	1,	'0000-00-00 00:00:00',	0),
(31,	1,	'EOCS Daman',	'',	'',	'',	'',	'',	1,	'2020-10-10 13:41:00',	1,	'0000-00-00 00:00:00',	0),
(32,	2,	'EOCS Diu',	'',	'',	'',	'',	'',	1,	'2020-10-10 13:42:00',	1,	'0000-00-00 00:00:00',	0),
(33,	3,	'Survey and Settlement DNH',	'',	'',	'',	'',	'',	1,	'2020-10-10 13:42:00',	1,	'0000-00-00 00:00:00',	0),
(34,	1,	'Dist Panchayat Daman',	'',	'',	'',	'',	'',	1,	'2020-10-10 13:45:00',	1,	'0000-00-00 00:00:00',	0),
(35,	2,	'Dist Panchayat Diu',	'',	'',	'',	'',	'',	1,	'2020-10-10 13:45:00',	1,	'0000-00-00 00:00:00',	0),
(36,	3,	'Dist Panchayat DNH',	'',	'',	'',	'',	'',	1,	'2020-10-10 13:46:00',	1,	'0000-00-00 00:00:00',	0),
(37,	1,	'PDA Daman',	'',	'',	'',	'',	'',	1,	'2020-10-10 13:51:00',	1,	'0000-00-00 00:00:00',	0),
(38,	2,	'PDA Diu',	'',	'',	'',	'',	'',	1,	'2020-10-10 13:52:00',	1,	'0000-00-00 00:00:00',	0),
(39,	3,	'PDA DNH',	'',	'',	'',	'',	'',	1,	'2020-10-10 13:52:00',	1,	'0000-00-00 00:00:00',	0),
(40,	1,	'Tourism Daman',	'',	'',	'',	'',	'',	1,	'2020-10-10 13:54:00',	0,	'0000-00-00 00:00:00',	0),
(41,	3,	'GST DNH',	'',	'',	'',	'',	'',	1,	'2020-10-13 16:06:00',	1,	'0000-00-00 00:00:00',	0),
(42,	1,	'ARCS Daman',	'',	'',	'',	'',	'',	1,	'2020-11-25 18:34:00',	1,	'0000-00-00 00:00:00',	0),
(43,	2,	'ARCS Diu',	'',	'',	'',	'',	'',	1,	'2020-11-25 18:35:00',	1,	'0000-00-00 00:00:00',	0),
(44,	3,	'ARCS DNH',	'',	'',	'',	'',	'',	1,	'2020-11-25 18:36:00',	1,	'0000-00-00 00:00:00',	0),
(45,	1,	'Other',	'',	'',	'',	'',	'',	0,	'0000-00-00 00:00:00',	0,	'0000-00-00 00:00:00',	0),
(46,	2,	'Other',	'',	'',	'',	'',	'',	0,	'0000-00-00 00:00:00',	0,	'0000-00-00 00:00:00',	0),
(47,	3,	'Other',	'',	'',	'',	'',	'',	0,	'0000-00-00 00:00:00',	0,	'0000-00-00 00:00:00',	0),
(48,	1,	'Office of the Administrator',	'',	'',	'',	'',	'',	0,	'2022-07-20 13:59:03',	0,	'0000-00-00 00:00:00',	0);

DROP TABLE IF EXISTS `logs_email`;
CREATE TABLE `logs_email` (
  `email_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `email_type` tinyint(1) NOT NULL,
  `module_type` tinyint(4) NOT NULL,
  `module_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_time` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`email_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `sa_logs_change_password`;
CREATE TABLE `sa_logs_change_password` (
  `sa_logs_change_password_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sa_user_id` bigint(20) NOT NULL,
  `old_password` text NOT NULL,
  `new_password` text NOT NULL,
  `created_time` datetime NOT NULL,
  PRIMARY KEY (`sa_logs_change_password_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `sa_logs_login_details`;
CREATE TABLE `sa_logs_login_details` (
  `sa_logs_login_details_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sa_user_id` bigint(20) NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `login_timestamp` int(11) NOT NULL,
  `logout_timestamp` int(11) NOT NULL,
  `logs_data` text NOT NULL,
  `created_time` datetime NOT NULL,
  `updated_time` datetime NOT NULL,
  PRIMARY KEY (`sa_logs_login_details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `sa_users`;
CREATE TABLE `sa_users` (
  `sa_user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `mobile_number` varchar(10) NOT NULL,
  `email` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `user_type` tinyint(1) NOT NULL,
  `department_id` int(11) NOT NULL,
  `district` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_time` datetime NOT NULL,
  `updated_by` bigint(20) NOT NULL,
  `updated_time` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`sa_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `sa_users` (`sa_user_id`, `name`, `mobile_number`, `email`, `username`, `password`, `user_type`, `department_id`, `district`, `status`, `created_by`, `created_time`, `updated_by`, `updated_time`, `is_delete`) VALUES
(1,	'Admin',	'',	'',	'admin',	'a3b95c823ebf97bcdc7fa5b9cadf140a3635613965663466613163623639643664393664343738393039663066663533386532656233363133303462643761626137643333353561383966336364303296b68b26e7b48da2ecc8',	1,	0,	0,	0,	1,	'2020-03-25 17:20:00',	1,	'2022-07-15 21:04:55',	0),
(2,	'Daman Labour & Employement',	'',	'',	'daman.labour',	'7f529ec0191850a8c5c4689b4b8f042e353937666566646338306139643737643163363563306237333961386366393461656661626135646565383536366164343630336132386234376466306265308005f5092b2dc20cac45',	2,	1,	1,	0,	1,	'2022-07-15 21:05:46',	1,	'2022-07-16 11:48:12',	0);

DROP TABLE IF EXISTS `sa_user_type`;
CREATE TABLE `sa_user_type` (
  `sa_user_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(200) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_time` datetime NOT NULL,
  `updated_by` bigint(20) NOT NULL,
  `updated_time` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`sa_user_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `sa_user_type` (`sa_user_type_id`, `type`, `created_by`, `created_time`, `updated_by`, `updated_time`, `is_delete`) VALUES
(1,	'Admin',	1,	'2020-03-25 13:54:00',	1,	'2022-07-15 16:50:00',	0),
(2,	'Department User',	1,	'2022-07-15 20:56:00',	0,	'0000-00-00 00:00:00',	0);

DROP TABLE IF EXISTS `service`;
CREATE TABLE `service` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `district` tinyint(1) NOT NULL,
  `department_id` int(11) NOT NULL,
  `service_name` varchar(200) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `first_app_for_gr` varchar(100) NOT NULL,
  `second_app_for_gr` varchar(100) NOT NULL,
  `declared_in` varchar(200) NOT NULL,
  `declared_in_remarks` varchar(200) NOT NULL,
  `delivery_type` tinyint(1) NOT NULL,
  `delivery_remarks` varchar(200) NOT NULL,
  `service_url` text NOT NULL,
  `days_as_per_cc` varchar(3) NOT NULL,
  `days_as_per_sss` varchar(3) NOT NULL,
  `ds_category` varchar(200) NOT NULL,
  `ds_other_category` varchar(200) NOT NULL,
  `is_delivery_fees` tinyint(1) NOT NULL,
  `delivery_fees_details` text NOT NULL,
  `total_delivery_fees` decimal(12,0) NOT NULL,
  `is_payment_to_applicant` tinyint(1) NOT NULL,
  `applicant_payment_type` tinyint(1) NOT NULL,
  `applicant_payment_details` text NOT NULL,
  `total_applicant_payment` decimal(12,0) NOT NULL,
  `cc_doc` varchar(100) NOT NULL,
  `process_flow_doc` varchar(100) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `submitted_datetime` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_time` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_time` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `service_req_doc`;
CREATE TABLE `service_req_doc` (
  `service_req_doc_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `doc_name` varchar(100) NOT NULL,
  `requirement_type` tinyint(1) NOT NULL,
  `document` varchar(100) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_time` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_time` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`service_req_doc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `service_sas_doc`;
CREATE TABLE `service_sas_doc` (
  `service_sas_doc_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `doc_name` varchar(100) NOT NULL,
  `document` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_time` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_time` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`service_sas_doc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2022-08-03 05:10:48
