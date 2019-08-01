# MySQL backup created by phpMySQLAutoBackup
#
# http://www.dwalker.co.uk/phpmysqlautobackup/
#
# Database: smportal
# Domain name: localhost
# (c)2013 localhost
#
# Backup START time: 11:12:49
# Backup END time: 11:12:50
# Backup Date: 19 Oct 2013

drop table if exists `additional_exam_groups`;
; 

drop table if exists `additional_exam_scores`;
; 

drop table if exists `additional_exams`;
; 

drop table if exists `archive_attendances`;
; 

drop table if exists `archive_exam_scores`;
; 

drop table if exists `archive_students`;
; 

drop table if exists `attendances`;
; 

drop table if exists `batch_events`;
; 

drop table if exists `batches`;
; 

drop table if exists `batches_template`;
; 

drop table if exists `class_timings`;
; 

drop table if exists `countries`;
; 

drop table if exists `employee_categories`;
; 

drop table if exists `employee_departments`;
; 

drop table if exists `employee_positions`;
; 

drop table if exists `employees`;
; 

drop table if exists `employees_subjects`;
; 

drop table if exists `events`;
; 

drop table if exists `exam_groups`;
; 

drop table if exists `exam_scores`;
; 

drop table if exists `exams`;
; 

drop table if exists `generate_final_score`;
CREATE TABLE `generate_final_score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schoolid` int(10) NOT NULL,
  `batchid` int(10) NOT NULL,
  `sem_id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `stu_max_marks` int(50) NOT NULL,
  `stu_obt_marks` int(50) NOT NULL,
  `percentage` float(15,2) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1; 
insert into `generate_final_score` (`id`, `schoolid`, `batchid`, `sem_id`, `student_id`, `stu_max_marks`, `stu_obt_marks`, `percentage`, `status`) values ('1', '4', '13', '1', '28', '200', '158', '79.00', '1');
insert into `generate_final_score` (`id`, `schoolid`, `batchid`, `sem_id`, `student_id`, `stu_max_marks`, `stu_obt_marks`, `percentage`, `status`) values ('2', '4', '13', '1', '29', '200', '127', '63.50', '1');
insert into `generate_final_score` (`id`, `schoolid`, `batchid`, `sem_id`, `student_id`, `stu_max_marks`, `stu_obt_marks`, `percentage`, `status`) values ('3', '4', '13', '1', '32', '200', '179', '89.50', '1');
insert into `generate_final_score` (`id`, `schoolid`, `batchid`, `sem_id`, `student_id`, `stu_max_marks`, `stu_obt_marks`, `percentage`, `status`) values ('12', '4', '13', '2', '32', '200', '117', '58.50', '1');
insert into `generate_final_score` (`id`, `schoolid`, `batchid`, `sem_id`, `student_id`, `stu_max_marks`, `stu_obt_marks`, `percentage`, `status`) values ('11', '4', '13', '2', '29', '200', '139', '69.50', '1');
insert into `generate_final_score` (`id`, `schoolid`, `batchid`, `sem_id`, `student_id`, `stu_max_marks`, `stu_obt_marks`, `percentage`, `status`) values ('10', '4', '13', '2', '28', '200', '119', '59.50', '1');
insert into `generate_final_score` (`id`, `schoolid`, `batchid`, `sem_id`, `student_id`, `stu_max_marks`, `stu_obt_marks`, `percentage`, `status`) values ('13', '4', '9', '1', '36', '200', '115', '57.50', '1');

drop table if exists `grades`;
; 

drop table if exists `grades_template`;
; 

drop table if exists `grading_levels`;
; 

drop table if exists `grouped_exams`;
; 

drop table if exists `guardians`;
; 

drop table if exists `label_values`;
; 

drop table if exists `period_entries`;
; 

drop table if exists `phpmysqlautobackup`;
CREATE TABLE `phpmysqlautobackup` (
  `id` int(11) NOT NULL,
  `version` varchar(6) DEFAULT NULL,
  `time_last_run` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1; 
insert into `phpmysqlautobackup` (`id`, `version`, `time_last_run`) values ('1', '1.5.2', '1382161369');

drop table if exists `reminder_group`;
CREATE TABLE `reminder_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `senderID` int(11) NOT NULL,
  `rec_m_IDs` varchar(1000) NOT NULL,
  `rec_s_IDs` varchar(1000) NOT NULL,
  `rec_p_IDs` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1; 
insert into `reminder_group` (`id`, `senderID`, `rec_m_IDs`, `rec_s_IDs`, `rec_p_IDs`) values ('1', '6', '2', '', '');

drop table if exists `reminders`;
; 

drop table if exists `request_student`;
CREATE TABLE `request_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `curr_school_id` int(50) NOT NULL,
  `to_school` int(100) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `message` varchar(200) NOT NULL,
  `sec_id` int(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `act_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1; 
insert into `request_student` (`id`, `curr_school_id`, `to_school`, `student_id`, `message`, `sec_id`, `status`, `act_status`) values ('8', '1', '4', '36', 'student details', '20', '1', '2');
insert into `request_student` (`id`, `curr_school_id`, `to_school`, `student_id`, `message`, `sec_id`, `status`, `act_status`) values ('9', '4', '1', '24', 'we want information', '2', '1', '2');

drop table if exists `school`;
CREATE TABLE `school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `code` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phno` varchar(40) NOT NULL,
  `mhno` varchar(40) NOT NULL,
  `logo` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `emplogin` int(1) NOT NULL DEFAULT '1',
  `parentlogin` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1; 
insert into `school` (`id`, `name`, `code`, `address`, `phno`, `mhno`, `logo`, `status`, `emplogin`, `parentlogin`) values ('1', 'LBS School', 'lbsschool', 'Paota Jodhpur', '0219425786', '0291236547', '1381.png', '1', '1', '1');
insert into `school` (`id`, `name`, `code`, `address`, `phno`, `mhno`, `logo`, `status`, `emplogin`, `parentlogin`) values ('2', 'St. Xavier Secondary School', '', 'Ratanada, Jodhpur', '02912646856', '255649532', '', '1', '1', '1');
insert into `school` (`id`, `name`, `code`, `address`, `phno`, `mhno`, `logo`, `status`, `emplogin`, `parentlogin`) values ('4', 'Vidhya Bhawan', '', 'Pal link main, Jodhppur', '0291-2646859', '', '4229.jpg', '1', '1', '1');
insert into `school` (`id`, `name`, `code`, `address`, `phno`, `mhno`, `logo`, `status`, `emplogin`, `parentlogin`) values ('6', 'New LBS School', '', 'Mohan Nagar', '029178542', '', '6495.jpg', '1', '1', '1');

drop table if exists `student_note`;
CREATE TABLE `student_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `schoolid` int(11) NOT NULL,
  `write_by` int(11) NOT NULL,
  `note` text NOT NULL,
  `write_dt` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1; 
insert into `student_note` (`id`, `student_id`, `schoolid`, `write_by`, `note`, `write_dt`, `status`) values ('1', '3', '1', '6', 'test test test test ', '2011-12-04 23:04:51', '1');
insert into `student_note` (`id`, `student_id`, `schoolid`, `write_by`, `note`, `write_dt`, `status`) values ('2', '3', '1', '2', 'wrgqerwg asfg', '2011-12-05 03:30:48', '1');
insert into `student_note` (`id`, `student_id`, `schoolid`, `write_by`, `note`, `write_dt`, `status`) values ('3', '3', '1', '2', 'adfgd adfgh', '2011-12-05 03:32:51', '1');
insert into `student_note` (`id`, `student_id`, `schoolid`, `write_by`, `note`, `write_dt`, `status`) values ('4', '16', '1', '25', 'this student is good on english
', '2011-12-09 12:36:58', '1');
insert into `student_note` (`id`, `student_id`, `schoolid`, `write_by`, `note`, `write_dt`, `status`) values ('5', '16', '1', '8', 'should maintain proper attendance in class', '2011-12-09 12:41:43', '1');
insert into `student_note` (`id`, `student_id`, `schoolid`, `write_by`, `note`, `write_dt`, `status`) values ('6', '33', '1', '2', 'aa', '2012-03-12 01:25:41', '1');

drop table if exists `student_previous_datas`;
; 

drop table if exists `students`;
; 

drop table if exists `subjects`;
; 

drop table if exists `subjects_template`;
; 

drop table if exists `teacher_to_grade`;
CREATE TABLE `teacher_to_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schoolid` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `empid` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1; 
insert into `teacher_to_grade` (`id`, `schoolid`, `batch_id`, `empid`, `status`) values ('1', '1', '2', '1', '1');

drop table if exists `ticket`;
CREATE TABLE `ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `createon` datetime NOT NULL,
  `notifydate` date NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1; 
insert into `ticket` (`id`, `title`, `description`, `is_read`, `created_by`, `createon`, `notifydate`, `status`) values ('1', 'annual meet', 'we are organizing annual meet 2011 ', NULL, '0', '2011-11-12 14:29:42', '2011-11-14', '1');
insert into `ticket` (`id`, `title`, `description`, `is_read`, `created_by`, `createon`, `notifydate`, `status`) values ('2', 'as', 'afadf', NULL, '1', '2011-11-23 10:20:32', '0000-00-00', '1');
insert into `ticket` (`id`, `title`, `description`, `is_read`, `created_by`, `createon`, `notifydate`, `status`) values ('3', 'cvcvb', 'cvbcvb', NULL, '2', '2011-11-23 15:12:54', '0000-00-00', '1');
insert into `ticket` (`id`, `title`, `description`, `is_read`, `created_by`, `createon`, `notifydate`, `status`) values ('4', 'ad', 'dgasdg', NULL, '2', '2011-12-03 13:04:20', '0000-00-00', '1');

drop table if exists `ticket_assigned`;
CREATE TABLE `ticket_assigned` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticketid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1; 
insert into `ticket_assigned` (`id`, `ticketid`, `userid`, `status`) values ('1', '1', '3', '1');
insert into `ticket_assigned` (`id`, `ticketid`, `userid`, `status`) values ('2', '3', '3', '1');
insert into `ticket_assigned` (`id`, `ticketid`, `userid`, `status`) values ('3', '3', '8', '1');
insert into `ticket_assigned` (`id`, `ticketid`, `userid`, `status`) values ('4', '3', '5', '1');
insert into `ticket_assigned` (`id`, `ticketid`, `userid`, `status`) values ('5', '3', '2', '1');
insert into `ticket_assigned` (`id`, `ticketid`, `userid`, `status`) values ('6', '3', '1', '1');
insert into `ticket_assigned` (`id`, `ticketid`, `userid`, `status`) values ('7', '3', '9', '1');
insert into `ticket_assigned` (`id`, `ticketid`, `userid`, `status`) values ('8', '3', '7', '1');
insert into `ticket_assigned` (`id`, `ticketid`, `userid`, `status`) values ('9', '3', '4', '1');

drop table if exists `ticket_commented`;
CREATE TABLE `ticket_commented` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticketid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `usercomment` varchar(250) NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1; 
insert into `ticket_commented` (`id`, `ticketid`, `userid`, `usercomment`, `date`, `status`) values ('1', '3', '12', 'Distribution of substantively modified versions of this document is prohibited without the explicit permission of the copyright holder', '2011-11-24 14:40:18', '1');
insert into `ticket_commented` (`id`, `ticketid`, `userid`, `usercomment`, `date`, `status`) values ('2', '3', '16', 'In case you are interested in redistribution or republishing of this document in whole or in part, either modified or unmodified, and you have questions, please contact the copyright holders at » doc-license@lists.php.net.', '2011-11-23 00:00:00', '1');
insert into `ticket_commented` (`id`, `ticketid`, `userid`, `usercomment`, `date`, `status`) values ('3', '0', '0', 'afa', '2011-12-01 12:48:10', '1');
insert into `ticket_commented` (`id`, `ticketid`, `userid`, `usercomment`, `date`, `status`) values ('4', '0', '0', 'afaf', '2011-12-01 12:48:30', '1');
insert into `ticket_commented` (`id`, `ticketid`, `userid`, `usercomment`, `date`, `status`) values ('5', '3', '2', 'afafa', '2011-12-01 12:50:44', '1');
insert into `ticket_commented` (`id`, `ticketid`, `userid`, `usercomment`, `date`, `status`) values ('6', '3', '2', 'rrrADFa', '2011-12-01 12:51:56', '1');
insert into `ticket_commented` (`id`, `ticketid`, `userid`, `usercomment`, `date`, `status`) values ('7', '3', '1', 'hello..........', '2011-12-01 12:53:33', '1');

drop table if exists `timetable_entries`;
; 

drop table if exists `timezone`;
CREATE TABLE `timezone` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `code` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=546 DEFAULT CHARSET=latin1; 
insert into `timezone` (`id`, `name`, `code`) values ('1', 'Africa/Abidjan', 'Africa/Abidjan');
insert into `timezone` (`id`, `name`, `code`) values ('2', 'Africa/Accra', 'Africa/Accra');
insert into `timezone` (`id`, `name`, `code`) values ('3', 'Africa/Addis_Ababa', 'Africa/Addis_Ababa');
insert into `timezone` (`id`, `name`, `code`) values ('4', 'Africa/Algiers', 'Africa/Algiers');
insert into `timezone` (`id`, `name`, `code`) values ('5', 'Africa/Asmara', 'Africa/Asmara');
insert into `timezone` (`id`, `name`, `code`) values ('6', 'Africa/Asmera', 'Africa/Asmera');
insert into `timezone` (`id`, `name`, `code`) values ('7', 'Africa/Bamako', 'Africa/Bamako');
insert into `timezone` (`id`, `name`, `code`) values ('8', 'Africa/Bangui', 'Africa/Bangui');
insert into `timezone` (`id`, `name`, `code`) values ('9', 'Africa/Banjul', 'Africa/Banjul');
insert into `timezone` (`id`, `name`, `code`) values ('10', 'Africa/Bissau', 'Africa/Bissau');
insert into `timezone` (`id`, `name`, `code`) values ('11', 'Africa/Blantyre', 'Africa/Blantyre');
insert into `timezone` (`id`, `name`, `code`) values ('12', 'Africa/Brazzaville', 'Africa/Brazzaville');
insert into `timezone` (`id`, `name`, `code`) values ('13', 'Africa/Bujumbura', 'Africa/Bujumbura');
insert into `timezone` (`id`, `name`, `code`) values ('14', 'Africa/Cairo', 'Africa/Cairo');
insert into `timezone` (`id`, `name`, `code`) values ('15', 'Africa/Casablanca', 'Africa/Casablanca');
insert into `timezone` (`id`, `name`, `code`) values ('16', 'Africa/Ceuta', 'Africa/Ceuta');
insert into `timezone` (`id`, `name`, `code`) values ('17', 'Africa/Conakry', 'Africa/Conakry');
insert into `timezone` (`id`, `name`, `code`) values ('18', 'Africa/Dakar', 'Africa/Dakar');
insert into `timezone` (`id`, `name`, `code`) values ('19', 'Africa/Dar_es_Salaam', 'Africa/Dar_es_Salaam');
insert into `timezone` (`id`, `name`, `code`) values ('20', 'Africa/Djibouti', 'Africa/Djibouti');
insert into `timezone` (`id`, `name`, `code`) values ('21', 'Africa/Douala', 'Africa/Douala');
insert into `timezone` (`id`, `name`, `code`) values ('22', 'Africa/El_Aaiun', 'Africa/El_Aaiun');
insert into `timezone` (`id`, `name`, `code`) values ('23', 'Africa/Freetown', 'Africa/Freetown');
insert into `timezone` (`id`, `name`, `code`) values ('24', 'Africa/Gaborone', 'Africa/Gaborone');
insert into `timezone` (`id`, `name`, `code`) values ('25', 'Africa/Harare', 'Africa/Harare');
insert into `timezone` (`id`, `name`, `code`) values ('26', 'Africa/Johannesburg', 'Africa/Johannesburg');
insert into `timezone` (`id`, `name`, `code`) values ('27', 'Africa/Kampala', 'Africa/Kampala');
insert into `timezone` (`id`, `name`, `code`) values ('28', 'Africa/Khartoum', 'Africa/Khartoum');
insert into `timezone` (`id`, `name`, `code`) values ('29', 'Africa/Kigali', 'Africa/Kigali');
insert into `timezone` (`id`, `name`, `code`) values ('30', 'Africa/Kinshasa', 'Africa/Kinshasa');
insert into `timezone` (`id`, `name`, `code`) values ('31', 'Africa/Lagos', 'Africa/Lagos');
insert into `timezone` (`id`, `name`, `code`) values ('32', 'Africa/Libreville', 'Africa/Libreville');
insert into `timezone` (`id`, `name`, `code`) values ('33', 'Africa/Lome', 'Africa/Lome');
insert into `timezone` (`id`, `name`, `code`) values ('34', 'Africa/Luanda', 'Africa/Luanda');
insert into `timezone` (`id`, `name`, `code`) values ('35', 'Africa/Lubumbashi', 'Africa/Lubumbashi');
insert into `timezone` (`id`, `name`, `code`) values ('36', 'Africa/Lusaka', 'Africa/Lusaka');
insert into `timezone` (`id`, `name`, `code`) values ('37', 'Africa/Malabo', 'Africa/Malabo');
insert into `timezone` (`id`, `name`, `code`) values ('38', 'Africa/Maputo', 'Africa/Maputo');
insert into `timezone` (`id`, `name`, `code`) values ('39', 'Africa/Maseru', 'Africa/Maseru');
insert into `timezone` (`id`, `name`, `code`) values ('40', 'Africa/Mbabane', 'Africa/Mbabane');
insert into `timezone` (`id`, `name`, `code`) values ('41', 'Africa/Mogadishu', 'Africa/Mogadishu');
insert into `timezone` (`id`, `name`, `code`) values ('42', 'Africa/Monrovia', 'Africa/Monrovia');
insert into `timezone` (`id`, `name`, `code`) values ('43', 'Africa/Nairobi', 'Africa/Nairobi');
insert into `timezone` (`id`, `name`, `code`) values ('44', 'Africa/Ndjamena', 'Africa/Ndjamena');
insert into `timezone` (`id`, `name`, `code`) values ('45', 'Africa/Niamey', 'Africa/Niamey');
insert into `timezone` (`id`, `name`, `code`) values ('46', 'Africa/Nouakchott', 'Africa/Nouakchott');
insert into `timezone` (`id`, `name`, `code`) values ('47', 'Africa/Ouagadougou', 'Africa/Ouagadougou');
insert into `timezone` (`id`, `name`, `code`) values ('48', 'Africa/Porto-Novo', 'Africa/Porto-Novo');
insert into `timezone` (`id`, `name`, `code`) values ('49', 'Africa/Sao_Tome', 'Africa/Sao_Tome');
insert into `timezone` (`id`, `name`, `code`) values ('50', 'Africa/Timbuktu', 'Africa/Timbuktu');
insert into `timezone` (`id`, `name`, `code`) values ('51', 'Africa/Tripoli', 'Africa/Tripoli');
insert into `timezone` (`id`, `name`, `code`) values ('52', 'Africa/Tunis', 'Africa/Tunis');
insert into `timezone` (`id`, `name`, `code`) values ('53', 'Africa/Windhoek', 'Africa/Windhoek');
insert into `timezone` (`id`, `name`, `code`) values ('54', 'America/Adak', 'America/Adak');
insert into `timezone` (`id`, `name`, `code`) values ('55', 'America/Anchorage', 'America/Anchorage');
insert into `timezone` (`id`, `name`, `code`) values ('56', 'America/Anguilla', 'America/Anguilla');
insert into `timezone` (`id`, `name`, `code`) values ('57', 'America/Antigua', 'America/Antigua');
insert into `timezone` (`id`, `name`, `code`) values ('58', 'America/Araguaina', 'America/Araguaina');
insert into `timezone` (`id`, `name`, `code`) values ('59', 'America/Argentina', 'America/Argentina');
insert into `timezone` (`id`, `name`, `code`) values ('60', 'America/Aruba', 'America/Aruba');
insert into `timezone` (`id`, `name`, `code`) values ('61', 'America/Asuncion', 'America/Asuncion');
insert into `timezone` (`id`, `name`, `code`) values ('62', 'America/Atikokan', 'America/Atikokan');
insert into `timezone` (`id`, `name`, `code`) values ('63', 'America/Atka', 'America/Atka');
insert into `timezone` (`id`, `name`, `code`) values ('64', 'America/Bahia', 'America/Bahia');
insert into `timezone` (`id`, `name`, `code`) values ('65', 'America/Bahia_Banderas', 'America/Bahia_Banderas');
insert into `timezone` (`id`, `name`, `code`) values ('66', 'America/Barbados', 'America/Barbados');
insert into `timezone` (`id`, `name`, `code`) values ('67', 'America/Belem', 'America/Belem');
insert into `timezone` (`id`, `name`, `code`) values ('68', 'America/Belize', 'America/Belize');
insert into `timezone` (`id`, `name`, `code`) values ('69', 'America/Blanc-Sablon', 'America/Blanc-Sablon');
insert into `timezone` (`id`, `name`, `code`) values ('70', 'America/Boa_Vista', 'America/Boa_Vista');
insert into `timezone` (`id`, `name`, `code`) values ('71', 'America/Bogota', 'America/Bogota');
insert into `timezone` (`id`, `name`, `code`) values ('72', 'America/Boise', 'America/Boise');
insert into `timezone` (`id`, `name`, `code`) values ('73', 'America/Buenos_Aires', 'America/Buenos_Aires');
insert into `timezone` (`id`, `name`, `code`) values ('74', 'America/Cambridge_Bay', 'America/Cambridge_Bay');
insert into `timezone` (`id`, `name`, `code`) values ('75', 'America/Campo_Grande', 'America/Campo_Grande');
insert into `timezone` (`id`, `name`, `code`) values ('76', 'America/Cancun', 'America/Cancun');
insert into `timezone` (`id`, `name`, `code`) values ('77', 'America/Caracas', 'America/Caracas');
insert into `timezone` (`id`, `name`, `code`) values ('78', 'America/Catamarca', 'America/Catamarca');
insert into `timezone` (`id`, `name`, `code`) values ('79', 'America/Cayenne', 'America/Cayenne');
insert into `timezone` (`id`, `name`, `code`) values ('80', 'America/Cayman', 'America/Cayman');
insert into `timezone` (`id`, `name`, `code`) values ('81', 'America/Chicago', 'America/Chicago');
insert into `timezone` (`id`, `name`, `code`) values ('82', 'America/Chihuahua', 'America/Chihuahua');
insert into `timezone` (`id`, `name`, `code`) values ('83', 'America/Coral_Harbour', 'America/Coral_Harbour');
insert into `timezone` (`id`, `name`, `code`) values ('84', 'America/Cordoba', 'America/Cordoba');
insert into `timezone` (`id`, `name`, `code`) values ('85', 'America/Costa_Rica', 'America/Costa_Rica');
insert into `timezone` (`id`, `name`, `code`) values ('86', 'America/Cuiaba', 'America/Cuiaba');
insert into `timezone` (`id`, `name`, `code`) values ('87', 'America/Curacao', 'America/Curacao');
insert into `timezone` (`id`, `name`, `code`) values ('88', 'America/Danmarkshavn', 'America/Danmarkshavn');
insert into `timezone` (`id`, `name`, `code`) values ('89', 'America/Dawson', 'America/Dawson');
insert into `timezone` (`id`, `name`, `code`) values ('90', 'America/Dawson_Creek', 'America/Dawson_Creek');
insert into `timezone` (`id`, `name`, `code`) values ('91', 'America/Denver', 'America/Denver');
insert into `timezone` (`id`, `name`, `code`) values ('92', 'America/Detroit', 'America/Detroit');
insert into `timezone` (`id`, `name`, `code`) values ('93', 'America/Dominica', 'America/Dominica');
insert into `timezone` (`id`, `name`, `code`) values ('94', 'America/Edmonton', 'America/Edmonton');
insert into `timezone` (`id`, `name`, `code`) values ('95', 'America/Eirunepe', 'America/Eirunepe');
insert into `timezone` (`id`, `name`, `code`) values ('96', 'America/El_Salvador', 'America/El_Salvador');
insert into `timezone` (`id`, `name`, `code`) values ('97', 'America/Ensenada', 'America/Ensenada');
insert into `timezone` (`id`, `name`, `code`) values ('98', 'America/Fort_Wayne', 'America/Fort_Wayne');
insert into `timezone` (`id`, `name`, `code`) values ('99', 'America/Fortaleza', 'America/Fortaleza');
insert into `timezone` (`id`, `name`, `code`) values ('100', 'America/Glace_Bay', 'America/Glace_Bay');
insert into `timezone` (`id`, `name`, `code`) values ('101', 'America/Godthab', 'America/Godthab');
insert into `timezone` (`id`, `name`, `code`) values ('102', 'America/Goose_Bay', 'America/Goose_Bay');
insert into `timezone` (`id`, `name`, `code`) values ('103', 'America/Grand_Turk', 'America/Grand_Turk');
insert into `timezone` (`id`, `name`, `code`) values ('104', 'America/Grenada', 'America/Grenada');
insert into `timezone` (`id`, `name`, `code`) values ('105', 'America/Guadeloupe', 'America/Guadeloupe');
insert into `timezone` (`id`, `name`, `code`) values ('106', 'America/Guatemala', 'America/Guatemala');
insert into `timezone` (`id`, `name`, `code`) values ('107', 'America/Guayaquil', 'America/Guayaquil');
insert into `timezone` (`id`, `name`, `code`) values ('108', 'America/Guyana', 'America/Guyana');
insert into `timezone` (`id`, `name`, `code`) values ('109', 'America/Halifax', 'America/Halifax');
insert into `timezone` (`id`, `name`, `code`) values ('110', 'America/Havana', 'America/Havana');
insert into `timezone` (`id`, `name`, `code`) values ('111', 'America/Hermosillo', 'America/Hermosillo');
insert into `timezone` (`id`, `name`, `code`) values ('112', 'America/Indiana', 'America/Indiana');
insert into `timezone` (`id`, `name`, `code`) values ('113', 'America/Indianapolis', 'America/Indianapolis');
insert into `timezone` (`id`, `name`, `code`) values ('114', 'America/Inuvik', 'America/Inuvik');
insert into `timezone` (`id`, `name`, `code`) values ('115', 'America/Iqaluit', 'America/Iqaluit');
insert into `timezone` (`id`, `name`, `code`) values ('116', 'America/Jamaica', 'America/Jamaica');
insert into `timezone` (`id`, `name`, `code`) values ('117', 'America/Jujuy', 'America/Jujuy');
insert into `timezone` (`id`, `name`, `code`) values ('118', 'America/Juneau', 'America/Juneau');
insert into `timezone` (`id`, `name`, `code`) values ('119', 'America/Kentucky', 'America/Kentucky');
insert into `timezone` (`id`, `name`, `code`) values ('120', 'America/Knox_IN', 'America/Knox_IN');
insert into `timezone` (`id`, `name`, `code`) values ('121', 'America/La_Paz', 'America/La_Paz');
insert into `timezone` (`id`, `name`, `code`) values ('122', 'America/Lima', 'America/Lima');
insert into `timezone` (`id`, `name`, `code`) values ('123', 'America/Los_Angeles', 'America/Los_Angeles');
insert into `timezone` (`id`, `name`, `code`) values ('124', 'America/Louisville', 'America/Louisville');
insert into `timezone` (`id`, `name`, `code`) values ('125', 'America/Maceio', 'America/Maceio');
insert into `timezone` (`id`, `name`, `code`) values ('126', 'America/Managua', 'America/Managua');
insert into `timezone` (`id`, `name`, `code`) values ('127', 'America/Manaus', 'America/Manaus');
insert into `timezone` (`id`, `name`, `code`) values ('128', 'America/Marigot', 'America/Marigot');
insert into `timezone` (`id`, `name`, `code`) values ('129', 'America/Martinique', 'America/Martinique');
insert into `timezone` (`id`, `name`, `code`) values ('130', 'America/Matamoros', 'America/Matamoros');
insert into `timezone` (`id`, `name`, `code`) values ('131', 'America/Mazatlan', 'America/Mazatlan');
insert into `timezone` (`id`, `name`, `code`) values ('132', 'America/Mendoza', 'America/Mendoza');
insert into `timezone` (`id`, `name`, `code`) values ('133', 'America/Menominee', 'America/Menominee');
insert into `timezone` (`id`, `name`, `code`) values ('134', 'America/Merida', 'America/Merida');
insert into `timezone` (`id`, `name`, `code`) values ('135', 'America/Mexico_City', 'America/Mexico_City');
insert into `timezone` (`id`, `name`, `code`) values ('136', 'America/Miquelon', 'America/Miquelon');
insert into `timezone` (`id`, `name`, `code`) values ('137', 'America/Moncton', 'America/Moncton');
insert into `timezone` (`id`, `name`, `code`) values ('138', 'America/Monterrey', 'America/Monterrey');
insert into `timezone` (`id`, `name`, `code`) values ('139', 'America/Montevideo', 'America/Montevideo');
insert into `timezone` (`id`, `name`, `code`) values ('140', 'America/Montreal', 'America/Montreal');
insert into `timezone` (`id`, `name`, `code`) values ('141', 'America/Montserrat', 'America/Montserrat');
insert into `timezone` (`id`, `name`, `code`) values ('142', 'America/Nassau', 'America/Nassau');
insert into `timezone` (`id`, `name`, `code`) values ('143', 'America/New_York', 'America/New_York');
insert into `timezone` (`id`, `name`, `code`) values ('144', 'America/Nipigon', 'America/Nipigon');
insert into `timezone` (`id`, `name`, `code`) values ('145', 'America/Nome', 'America/Nome');
insert into `timezone` (`id`, `name`, `code`) values ('146', 'America/Noronha', 'America/Noronha');
insert into `timezone` (`id`, `name`, `code`) values ('147', 'America/North_Dakota', 'America/North_Dakota');
insert into `timezone` (`id`, `name`, `code`) values ('148', 'America/Ojinaga', 'America/Ojinaga');
insert into `timezone` (`id`, `name`, `code`) values ('149', 'America/Panama', 'America/Panama');
insert into `timezone` (`id`, `name`, `code`) values ('150', 'America/Pangnirtung', 'America/Pangnirtung');
insert into `timezone` (`id`, `name`, `code`) values ('151', 'America/Paramaribo', 'America/Paramaribo');
insert into `timezone` (`id`, `name`, `code`) values ('152', 'America/Phoenix', 'America/Phoenix');
insert into `timezone` (`id`, `name`, `code`) values ('153', 'America/Port-au-Prince', 'America/Port-au-Prince');
insert into `timezone` (`id`, `name`, `code`) values ('154', 'America/Port_of_Spain', 'America/Port_of_Spain');
insert into `timezone` (`id`, `name`, `code`) values ('155', 'America/Porto_Acre', 'America/Porto_Acre');
insert into `timezone` (`id`, `name`, `code`) values ('156', 'America/Porto_Velho', 'America/Porto_Velho');
insert into `timezone` (`id`, `name`, `code`) values ('157', 'America/Puerto_Rico', 'America/Puerto_Rico');
insert into `timezone` (`id`, `name`, `code`) values ('158', 'America/Rainy_River', 'America/Rainy_River');
insert into `timezone` (`id`, `name`, `code`) values ('159', 'America/Rankin_Inlet', 'America/Rankin_Inlet');
insert into `timezone` (`id`, `name`, `code`) values ('160', 'America/Recife', 'America/Recife');
insert into `timezone` (`id`, `name`, `code`) values ('161', 'America/Regina', 'America/Regina');
insert into `timezone` (`id`, `name`, `code`) values ('162', 'America/Resolute', 'America/Resolute');
insert into `timezone` (`id`, `name`, `code`) values ('163', 'America/Rio_Branco', 'America/Rio_Branco');
insert into `timezone` (`id`, `name`, `code`) values ('164', 'America/Rosario', 'America/Rosario');
insert into `timezone` (`id`, `name`, `code`) values ('165', 'America/Santa_Isabel', 'America/Santa_Isabel');
insert into `timezone` (`id`, `name`, `code`) values ('166', 'America/Santarem', 'America/Santarem');
insert into `timezone` (`id`, `name`, `code`) values ('167', 'America/Santiago', 'America/Santiago');
insert into `timezone` (`id`, `name`, `code`) values ('168', 'America/Santo_Domingo', 'America/Santo_Domingo');
insert into `timezone` (`id`, `name`, `code`) values ('169', 'America/Sao_Paulo', 'America/Sao_Paulo');
insert into `timezone` (`id`, `name`, `code`) values ('170', 'America/Scoresbysund', 'America/Scoresbysund');
insert into `timezone` (`id`, `name`, `code`) values ('171', 'America/Shiprock', 'America/Shiprock');
insert into `timezone` (`id`, `name`, `code`) values ('172', 'America/St_Barthelemy', 'America/St_Barthelemy');
insert into `timezone` (`id`, `name`, `code`) values ('173', 'America/St_Johns', 'America/St_Johns');
insert into `timezone` (`id`, `name`, `code`) values ('174', 'America/St_Kitts', 'America/St_Kitts');
insert into `timezone` (`id`, `name`, `code`) values ('175', 'America/St_Lucia', 'America/St_Lucia');
insert into `timezone` (`id`, `name`, `code`) values ('176', 'America/St_Thomas', 'America/St_Thomas');
insert into `timezone` (`id`, `name`, `code`) values ('177', 'America/St_Vincent', 'America/St_Vincent');
insert into `timezone` (`id`, `name`, `code`) values ('178', 'America/Swift_Current', 'America/Swift_Current');
insert into `timezone` (`id`, `name`, `code`) values ('179', 'America/Tegucigalpa', 'America/Tegucigalpa');
insert into `timezone` (`id`, `name`, `code`) values ('180', 'America/Thule', 'America/Thule');
insert into `timezone` (`id`, `name`, `code`) values ('181', 'America/Thunder_Bay', 'America/Thunder_Bay');
insert into `timezone` (`id`, `name`, `code`) values ('182', 'America/Tijuana', 'America/Tijuana');
insert into `timezone` (`id`, `name`, `code`) values ('183', 'America/Toronto', 'America/Toronto');
insert into `timezone` (`id`, `name`, `code`) values ('184', 'America/Tortola', 'America/Tortola');
insert into `timezone` (`id`, `name`, `code`) values ('185', 'America/Vancouver', 'America/Vancouver');
insert into `timezone` (`id`, `name`, `code`) values ('186', 'America/Virgin', 'America/Virgin');
insert into `timezone` (`id`, `name`, `code`) values ('187', 'America/Whitehorse', 'America/Whitehorse');
insert into `timezone` (`id`, `name`, `code`) values ('188', 'America/Winnipeg', 'America/Winnipeg');
insert into `timezone` (`id`, `name`, `code`) values ('189', 'America/Yakutat', 'America/Yakutat');
insert into `timezone` (`id`, `name`, `code`) values ('190', 'America/Yellowknife', 'America/Yellowknife');
insert into `timezone` (`id`, `name`, `code`) values ('191', 'Antarctica/Casey', 'Antarctica/Casey');
insert into `timezone` (`id`, `name`, `code`) values ('192', 'Antarctica/Davis', 'Antarctica/Davis');
insert into `timezone` (`id`, `name`, `code`) values ('193', 'Antarctica/DumontDUrville', 'Antarctica/DumontDUrville');
insert into `timezone` (`id`, `name`, `code`) values ('194', 'Antarctica/Macquarie', 'Antarctica/Macquarie');
insert into `timezone` (`id`, `name`, `code`) values ('195', 'Antarctica/Mawson', 'Antarctica/Mawson');
insert into `timezone` (`id`, `name`, `code`) values ('196', 'Antarctica/McMurdo', 'Antarctica/McMurdo');
insert into `timezone` (`id`, `name`, `code`) values ('197', 'Antarctica/Palmer', 'Antarctica/Palmer');
insert into `timezone` (`id`, `name`, `code`) values ('198', 'Antarctica/Rothera', 'Antarctica/Rothera');
insert into `timezone` (`id`, `name`, `code`) values ('199', 'Antarctica/South_Pole', 'Antarctica/South_Pole');
insert into `timezone` (`id`, `name`, `code`) values ('200', 'Antarctica/Syowa', 'Antarctica/Syowa');
insert into `timezone` (`id`, `name`, `code`) values ('201', 'Antarctica/Vostok', 'Antarctica/Vostok');
insert into `timezone` (`id`, `name`, `code`) values ('202', 'Arctic/Longyearbyen', 'Arctic/Longyearbyen');
insert into `timezone` (`id`, `name`, `code`) values ('203', 'Asia/Aden', 'Asia/Aden');
insert into `timezone` (`id`, `name`, `code`) values ('204', 'Asia/Almaty', 'Asia/Almaty');
insert into `timezone` (`id`, `name`, `code`) values ('205', 'Asia/Amman', 'Asia/Amman');
insert into `timezone` (`id`, `name`, `code`) values ('206', 'Asia/Anadyr', 'Asia/Anadyr');
insert into `timezone` (`id`, `name`, `code`) values ('207', 'Asia/Aqtau', 'Asia/Aqtau');
insert into `timezone` (`id`, `name`, `code`) values ('208', 'Asia/Aqtobe', 'Asia/Aqtobe');
insert into `timezone` (`id`, `name`, `code`) values ('209', 'Asia/Ashgabat', 'Asia/Ashgabat');
insert into `timezone` (`id`, `name`, `code`) values ('210', 'Asia/Ashkhabad', 'Asia/Ashkhabad');
insert into `timezone` (`id`, `name`, `code`) values ('211', 'Asia/Baghdad', 'Asia/Baghdad');
insert into `timezone` (`id`, `name`, `code`) values ('212', 'Asia/Bahrain', 'Asia/Bahrain');
insert into `timezone` (`id`, `name`, `code`) values ('213', 'Asia/Baku', 'Asia/Baku');
insert into `timezone` (`id`, `name`, `code`) values ('214', 'Asia/Bangkok', 'Asia/Bangkok');
insert into `timezone` (`id`, `name`, `code`) values ('215', 'Asia/Beirut', 'Asia/Beirut');
insert into `timezone` (`id`, `name`, `code`) values ('216', 'Asia/Bishkek', 'Asia/Bishkek');
insert into `timezone` (`id`, `name`, `code`) values ('217', 'Asia/Brunei', 'Asia/Brunei');
insert into `timezone` (`id`, `name`, `code`) values ('218', 'Asia/Calcutta', 'Asia/Calcutta');
insert into `timezone` (`id`, `name`, `code`) values ('219', 'Asia/Choibalsan', 'Asia/Choibalsan');
insert into `timezone` (`id`, `name`, `code`) values ('220', 'Asia/Chongqing', 'Asia/Chongqing');
insert into `timezone` (`id`, `name`, `code`) values ('221', 'Asia/Chungking', 'Asia/Chungking');
insert into `timezone` (`id`, `name`, `code`) values ('222', 'Asia/Colombo', 'Asia/Colombo');
insert into `timezone` (`id`, `name`, `code`) values ('223', 'Asia/Dacca', 'Asia/Dacca');
insert into `timezone` (`id`, `name`, `code`) values ('224', 'Asia/Damascus', 'Asia/Damascus');
insert into `timezone` (`id`, `name`, `code`) values ('225', 'Asia/Dhaka', 'Asia/Dhaka');
insert into `timezone` (`id`, `name`, `code`) values ('226', 'Asia/Dili', 'Asia/Dili');
insert into `timezone` (`id`, `name`, `code`) values ('227', 'Asia/Dubai', 'Asia/Dubai');
insert into `timezone` (`id`, `name`, `code`) values ('228', 'Asia/Dushanbe', 'Asia/Dushanbe');
insert into `timezone` (`id`, `name`, `code`) values ('229', 'Asia/Gaza', 'Asia/Gaza');
insert into `timezone` (`id`, `name`, `code`) values ('230', 'Asia/Harbin', 'Asia/Harbin');
insert into `timezone` (`id`, `name`, `code`) values ('231', 'Asia/Ho_Chi_Minh', 'Asia/Ho_Chi_Minh');
insert into `timezone` (`id`, `name`, `code`) values ('232', 'Asia/Hong_Kong', 'Asia/Hong_Kong');
insert into `timezone` (`id`, `name`, `code`) values ('233', 'Asia/Hovd', 'Asia/Hovd');
insert into `timezone` (`id`, `name`, `code`) values ('234', 'Asia/Irkutsk', 'Asia/Irkutsk');
insert into `timezone` (`id`, `name`, `code`) values ('235', 'Asia/Istanbul', 'Asia/Istanbul');
insert into `timezone` (`id`, `name`, `code`) values ('236', 'Asia/Jakarta', 'Asia/Jakarta');
insert into `timezone` (`id`, `name`, `code`) values ('237', 'Asia/Jayapura', 'Asia/Jayapura');
insert into `timezone` (`id`, `name`, `code`) values ('238', 'Asia/Jerusalem', 'Asia/Jerusalem');
insert into `timezone` (`id`, `name`, `code`) values ('239', 'Asia/Kabul', 'Asia/Kabul');
insert into `timezone` (`id`, `name`, `code`) values ('240', 'Asia/Kamchatka', 'Asia/Kamchatka');
insert into `timezone` (`id`, `name`, `code`) values ('241', 'Asia/Karachi', 'Asia/Karachi');
insert into `timezone` (`id`, `name`, `code`) values ('242', 'Asia/Kashgar', 'Asia/Kashgar');
insert into `timezone` (`id`, `name`, `code`) values ('243', 'Asia/Kathmandu', 'Asia/Kathmandu');
insert into `timezone` (`id`, `name`, `code`) values ('244', 'Asia/Katmandu', 'Asia/Katmandu');
insert into `timezone` (`id`, `name`, `code`) values ('245', 'Asia/Kolkata', 'Asia/Kolkata');
insert into `timezone` (`id`, `name`, `code`) values ('246', 'Asia/Krasnoyarsk', 'Asia/Krasnoyarsk');
insert into `timezone` (`id`, `name`, `code`) values ('247', 'Asia/Kuala_Lumpur', 'Asia/Kuala_Lumpur');
insert into `timezone` (`id`, `name`, `code`) values ('248', 'Asia/Kuching', 'Asia/Kuching');
insert into `timezone` (`id`, `name`, `code`) values ('249', 'Asia/Kuwait', 'Asia/Kuwait');
insert into `timezone` (`id`, `name`, `code`) values ('250', 'Asia/Macao', 'Asia/Macao');
insert into `timezone` (`id`, `name`, `code`) values ('251', 'Asia/Macau', 'Asia/Macau');
insert into `timezone` (`id`, `name`, `code`) values ('252', 'Asia/Magadan', 'Asia/Magadan');
insert into `timezone` (`id`, `name`, `code`) values ('253', 'Asia/Makassar', 'Asia/Makassar');
insert into `timezone` (`id`, `name`, `code`) values ('254', 'Asia/Manila', 'Asia/Manila');
insert into `timezone` (`id`, `name`, `code`) values ('255', 'Asia/Muscat', 'Asia/Muscat');
insert into `timezone` (`id`, `name`, `code`) values ('256', 'Asia/Nicosia', 'Asia/Nicosia');
insert into `timezone` (`id`, `name`, `code`) values ('257', 'Asia/Novokuznetsk', 'Asia/Novokuznetsk');
insert into `timezone` (`id`, `name`, `code`) values ('258', 'Asia/Novosibirsk', 'Asia/Novosibirsk');
insert into `timezone` (`id`, `name`, `code`) values ('259', 'Asia/Omsk', 'Asia/Omsk');
insert into `timezone` (`id`, `name`, `code`) values ('260', 'Asia/Oral', 'Asia/Oral');
insert into `timezone` (`id`, `name`, `code`) values ('261', 'Asia/Phnom_Penh', 'Asia/Phnom_Penh');
insert into `timezone` (`id`, `name`, `code`) values ('262', 'Asia/Pontianak', 'Asia/Pontianak');
insert into `timezone` (`id`, `name`, `code`) values ('263', 'Asia/Pyongyang', 'Asia/Pyongyang');
insert into `timezone` (`id`, `name`, `code`) values ('264', 'Asia/Qatar', 'Asia/Qatar');
insert into `timezone` (`id`, `name`, `code`) values ('265', 'Asia/Qyzylorda', 'Asia/Qyzylorda');
insert into `timezone` (`id`, `name`, `code`) values ('266', 'Asia/Rangoon', 'Asia/Rangoon');
insert into `timezone` (`id`, `name`, `code`) values ('267', 'Asia/Riyadh', 'Asia/Riyadh');
insert into `timezone` (`id`, `name`, `code`) values ('268', 'Asia/Saigon', 'Asia/Saigon');
insert into `timezone` (`id`, `name`, `code`) values ('269', 'Asia/Sakhalin', 'Asia/Sakhalin');
insert into `timezone` (`id`, `name`, `code`) values ('270', 'Asia/Samarkand', 'Asia/Samarkand');
insert into `timezone` (`id`, `name`, `code`) values ('271', 'Asia/Seoul', 'Asia/Seoul');
insert into `timezone` (`id`, `name`, `code`) values ('272', 'Asia/Shanghai', 'Asia/Shanghai');
insert into `timezone` (`id`, `name`, `code`) values ('273', 'Asia/Singapore', 'Asia/Singapore');
insert into `timezone` (`id`, `name`, `code`) values ('274', 'Asia/Taipei', 'Asia/Taipei');
insert into `timezone` (`id`, `name`, `code`) values ('275', 'Asia/Tashkent', 'Asia/Tashkent');
insert into `timezone` (`id`, `name`, `code`) values ('276', 'Asia/Tbilisi', 'Asia/Tbilisi');
insert into `timezone` (`id`, `name`, `code`) values ('277', 'Asia/Tehran', 'Asia/Tehran');
insert into `timezone` (`id`, `name`, `code`) values ('278', 'Asia/Tel_Aviv', 'Asia/Tel_Aviv');
insert into `timezone` (`id`, `name`, `code`) values ('279', 'Asia/Thimbu', 'Asia/Thimbu');
insert into `timezone` (`id`, `name`, `code`) values ('280', 'Asia/Thimphu', 'Asia/Thimphu');
insert into `timezone` (`id`, `name`, `code`) values ('281', 'Asia/Tokyo', 'Asia/Tokyo');
insert into `timezone` (`id`, `name`, `code`) values ('282', 'Asia/Ujung_Pandang', 'Asia/Ujung_Pandang');
insert into `timezone` (`id`, `name`, `code`) values ('283', 'Asia/Ulaanbaatar', 'Asia/Ulaanbaatar');
insert into `timezone` (`id`, `name`, `code`) values ('284', 'Asia/Ulan_Bator', 'Asia/Ulan_Bator');
insert into `timezone` (`id`, `name`, `code`) values ('285', 'Asia/Urumqi', 'Asia/Urumqi');
insert into `timezone` (`id`, `name`, `code`) values ('286', 'Asia/Vientiane', 'Asia/Vientiane');
insert into `timezone` (`id`, `name`, `code`) values ('287', 'Asia/Vladivostok', 'Asia/Vladivostok');
insert into `timezone` (`id`, `name`, `code`) values ('288', 'Asia/Yakutsk', 'Asia/Yakutsk');
insert into `timezone` (`id`, `name`, `code`) values ('289', 'Asia/Yekaterinburg', 'Asia/Yekaterinburg');
insert into `timezone` (`id`, `name`, `code`) values ('290', 'Asia/Yerevan', 'Asia/Yerevan');
insert into `timezone` (`id`, `name`, `code`) values ('291', 'Atlantic/Azores', 'Atlantic/Azores');
insert into `timezone` (`id`, `name`, `code`) values ('292', 'Atlantic/Bermuda', 'Atlantic/Bermuda');
insert into `timezone` (`id`, `name`, `code`) values ('293', 'Atlantic/Canary', 'Atlantic/Canary');
insert into `timezone` (`id`, `name`, `code`) values ('294', 'Atlantic/Cape_Verde', 'Atlantic/Cape_Verde');
insert into `timezone` (`id`, `name`, `code`) values ('295', 'Atlantic/Faeroe', 'Atlantic/Faeroe');
insert into `timezone` (`id`, `name`, `code`) values ('296', 'Atlantic/Faroe', 'Atlantic/Faroe');
insert into `timezone` (`id`, `name`, `code`) values ('297', 'Atlantic/Jan_Mayen', 'Atlantic/Jan_Mayen');
insert into `timezone` (`id`, `name`, `code`) values ('298', 'Atlantic/Madeira', 'Atlantic/Madeira');
insert into `timezone` (`id`, `name`, `code`) values ('299', 'Atlantic/Reykjavik', 'Atlantic/Reykjavik');
insert into `timezone` (`id`, `name`, `code`) values ('300', 'Atlantic/South_Georgia', 'Atlantic/South_Georgia');
insert into `timezone` (`id`, `name`, `code`) values ('301', 'Atlantic/St_Helena', 'Atlantic/St_Helena');
insert into `timezone` (`id`, `name`, `code`) values ('302', 'Atlantic/Stanley', 'Atlantic/Stanley');
insert into `timezone` (`id`, `name`, `code`) values ('303', 'Australia/ACT', 'Australia/ACT');
insert into `timezone` (`id`, `name`, `code`) values ('304', 'Australia/Adelaide', 'Australia/Adelaide');
insert into `timezone` (`id`, `name`, `code`) values ('305', 'Australia/Brisbane', 'Australia/Brisbane');
insert into `timezone` (`id`, `name`, `code`) values ('306', 'Australia/Broken_Hill', 'Australia/Broken_Hill');
insert into `timezone` (`id`, `name`, `code`) values ('307', 'Australia/Canberra', 'Australia/Canberra');
insert into `timezone` (`id`, `name`, `code`) values ('308', 'Australia/Currie', 'Australia/Currie');
insert into `timezone` (`id`, `name`, `code`) values ('309', 'Australia/Darwin', 'Australia/Darwin');
insert into `timezone` (`id`, `name`, `code`) values ('310', 'Australia/Eucla', 'Australia/Eucla');
insert into `timezone` (`id`, `name`, `code`) values ('311', 'Australia/Hobart', 'Australia/Hobart');
insert into `timezone` (`id`, `name`, `code`) values ('312', 'Australia/LHI', 'Australia/LHI');
insert into `timezone` (`id`, `name`, `code`) values ('313', 'Australia/Lindeman', 'Australia/Lindeman');
insert into `timezone` (`id`, `name`, `code`) values ('314', 'Australia/Lord_Howe', 'Australia/Lord_Howe');
insert into `timezone` (`id`, `name`, `code`) values ('315', 'Australia/Melbourne', 'Australia/Melbourne');
insert into `timezone` (`id`, `name`, `code`) values ('316', 'Australia/NSW', 'Australia/NSW');
insert into `timezone` (`id`, `name`, `code`) values ('317', 'Australia/North', 'Australia/North');
insert into `timezone` (`id`, `name`, `code`) values ('318', 'Australia/Perth', 'Australia/Perth');
insert into `timezone` (`id`, `name`, `code`) values ('319', 'Australia/Queensland', 'Australia/Queensland');
insert into `timezone` (`id`, `name`, `code`) values ('320', 'Australia/South', 'Australia/South');
insert into `timezone` (`id`, `name`, `code`) values ('321', 'Australia/Sydney', 'Australia/Sydney');
insert into `timezone` (`id`, `name`, `code`) values ('322', 'Australia/Tasmania', 'Australia/Tasmania');
insert into `timezone` (`id`, `name`, `code`) values ('323', 'Australia/Victoria', 'Australia/Victoria');
insert into `timezone` (`id`, `name`, `code`) values ('324', 'Australia/West', 'Australia/West');
insert into `timezone` (`id`, `name`, `code`) values ('325', 'Australia/Yancowinna', 'Australia/Yancowinna');
insert into `timezone` (`id`, `name`, `code`) values ('326', 'Brazil/Acre', 'Brazil/Acre');
insert into `timezone` (`id`, `name`, `code`) values ('327', 'Brazil/DeNoronha', 'Brazil/DeNoronha');
insert into `timezone` (`id`, `name`, `code`) values ('328', 'Brazil/East', 'Brazil/East');
insert into `timezone` (`id`, `name`, `code`) values ('329', 'Brazil/West', 'Brazil/West');
insert into `timezone` (`id`, `name`, `code`) values ('330', 'CET', 'CET');
insert into `timezone` (`id`, `name`, `code`) values ('331', 'CST6CDT', 'CST6CDT');
insert into `timezone` (`id`, `name`, `code`) values ('332', 'Canada/Atlantic', 'Canada/Atlantic');
insert into `timezone` (`id`, `name`, `code`) values ('333', 'Canada/Central', 'Canada/Central');
insert into `timezone` (`id`, `name`, `code`) values ('334', 'Canada/East-Saskatchewan', 'Canada/East-Saskatchewan');
insert into `timezone` (`id`, `name`, `code`) values ('335', 'Canada/Eastern', 'Canada/Eastern');
insert into `timezone` (`id`, `name`, `code`) values ('336', 'Canada/Mountain', 'Canada/Mountain');
insert into `timezone` (`id`, `name`, `code`) values ('337', 'Canada/Newfoundland', 'Canada/Newfoundland');
insert into `timezone` (`id`, `name`, `code`) values ('338', 'Canada/Pacific', 'Canada/Pacific');
insert into `timezone` (`id`, `name`, `code`) values ('339', 'Canada/Saskatchewan', 'Canada/Saskatchewan');
insert into `timezone` (`id`, `name`, `code`) values ('340', 'Canada/Yukon', 'Canada/Yukon');
insert into `timezone` (`id`, `name`, `code`) values ('341', 'Chile/Continental', 'Chile/Continental');
insert into `timezone` (`id`, `name`, `code`) values ('342', 'Chile/EasterIsland', 'Chile/EasterIsland');
insert into `timezone` (`id`, `name`, `code`) values ('343', 'Cuba', 'Cuba');
insert into `timezone` (`id`, `name`, `code`) values ('344', 'EET', 'EET');
insert into `timezone` (`id`, `name`, `code`) values ('345', 'EST', 'EST');
insert into `timezone` (`id`, `name`, `code`) values ('346', 'EST5EDT', 'EST5EDT');
insert into `timezone` (`id`, `name`, `code`) values ('347', 'Egypt', 'Egypt');
insert into `timezone` (`id`, `name`, `code`) values ('348', 'Eire', 'Eire');
insert into `timezone` (`id`, `name`, `code`) values ('349', 'Etc/GMT+0', 'Etc/GMT+0');
insert into `timezone` (`id`, `name`, `code`) values ('350', 'Etc/GMT+1', 'Etc/GMT+1');
insert into `timezone` (`id`, `name`, `code`) values ('351', 'Etc/GMT+10', 'Etc/GMT+10');
insert into `timezone` (`id`, `name`, `code`) values ('352', 'Etc/GMT+11', 'Etc/GMT+11');
insert into `timezone` (`id`, `name`, `code`) values ('353', 'Etc/GMT+12', 'Etc/GMT+12');
insert into `timezone` (`id`, `name`, `code`) values ('354', 'Etc/GMT+2', 'Etc/GMT+2');
insert into `timezone` (`id`, `name`, `code`) values ('355', 'Etc/GMT+3', 'Etc/GMT+3');
insert into `timezone` (`id`, `name`, `code`) values ('356', 'Etc/GMT+4', 'Etc/GMT+4');
insert into `timezone` (`id`, `name`, `code`) values ('357', 'Etc/GMT+5', 'Etc/GMT+5');
insert into `timezone` (`id`, `name`, `code`) values ('358', 'Etc/GMT+6', 'Etc/GMT+6');
insert into `timezone` (`id`, `name`, `code`) values ('359', 'Etc/GMT+7', 'Etc/GMT+7');
insert into `timezone` (`id`, `name`, `code`) values ('360', 'Etc/GMT+8', 'Etc/GMT+8');
insert into `timezone` (`id`, `name`, `code`) values ('361', 'Etc/GMT+9', 'Etc/GMT+9');
insert into `timezone` (`id`, `name`, `code`) values ('362', 'Etc/GMT-0', 'Etc/GMT-0');
insert into `timezone` (`id`, `name`, `code`) values ('363', 'Etc/GMT-1', 'Etc/GMT-1');
insert into `timezone` (`id`, `name`, `code`) values ('364', 'Etc/GMT-10', 'Etc/GMT-10');
insert into `timezone` (`id`, `name`, `code`) values ('365', 'Etc/GMT-11', 'Etc/GMT-11');
insert into `timezone` (`id`, `name`, `code`) values ('366', 'Etc/GMT-12', 'Etc/GMT-12');
insert into `timezone` (`id`, `name`, `code`) values ('367', 'Etc/GMT-13', 'Etc/GMT-13');
insert into `timezone` (`id`, `name`, `code`) values ('368', 'Etc/GMT-14', 'Etc/GMT-14');
insert into `timezone` (`id`, `name`, `code`) values ('369', 'Etc/GMT-2', 'Etc/GMT-2');
insert into `timezone` (`id`, `name`, `code`) values ('370', 'Etc/GMT-3', 'Etc/GMT-3');
insert into `timezone` (`id`, `name`, `code`) values ('371', 'Etc/GMT-4', 'Etc/GMT-4');
insert into `timezone` (`id`, `name`, `code`) values ('372', 'Etc/GMT-5', 'Etc/GMT-5');
insert into `timezone` (`id`, `name`, `code`) values ('373', 'Etc/GMT-6', 'Etc/GMT-6');
insert into `timezone` (`id`, `name`, `code`) values ('374', 'Etc/GMT-7', 'Etc/GMT-7');
insert into `timezone` (`id`, `name`, `code`) values ('375', 'Etc/GMT-8', 'Etc/GMT-8');
insert into `timezone` (`id`, `name`, `code`) values ('376', 'Etc/GMT-9', 'Etc/GMT-9');
insert into `timezone` (`id`, `name`, `code`) values ('377', 'Etc/GMT', 'Etc/GMT');
insert into `timezone` (`id`, `name`, `code`) values ('378', 'Etc/GMT0', 'Etc/GMT0');
insert into `timezone` (`id`, `name`, `code`) values ('379', 'Etc/Greenwich', 'Etc/Greenwich');
insert into `timezone` (`id`, `name`, `code`) values ('380', 'Etc/UCT', 'Etc/UCT');
insert into `timezone` (`id`, `name`, `code`) values ('381', 'Etc/UTC', 'Etc/UTC');
insert into `timezone` (`id`, `name`, `code`) values ('382', 'Etc/Universal', 'Etc/Universal');
insert into `timezone` (`id`, `name`, `code`) values ('383', 'Etc/Zulu', 'Etc/Zulu');
insert into `timezone` (`id`, `name`, `code`) values ('384', 'Europe/Amsterdam', 'Europe/Amsterdam');
insert into `timezone` (`id`, `name`, `code`) values ('385', 'Europe/Andorra', 'Europe/Andorra');
insert into `timezone` (`id`, `name`, `code`) values ('386', 'Europe/Athens', 'Europe/Athens');
insert into `timezone` (`id`, `name`, `code`) values ('387', 'Europe/Belfast', 'Europe/Belfast');
insert into `timezone` (`id`, `name`, `code`) values ('388', 'Europe/Belgrade', 'Europe/Belgrade');
insert into `timezone` (`id`, `name`, `code`) values ('389', 'Europe/Berlin', 'Europe/Berlin');
insert into `timezone` (`id`, `name`, `code`) values ('390', 'Europe/Bratislava', 'Europe/Bratislava');
insert into `timezone` (`id`, `name`, `code`) values ('391', 'Europe/Brussels', 'Europe/Brussels');
insert into `timezone` (`id`, `name`, `code`) values ('392', 'Europe/Bucharest', 'Europe/Bucharest');
insert into `timezone` (`id`, `name`, `code`) values ('393', 'Europe/Budapest', 'Europe/Budapest');
insert into `timezone` (`id`, `name`, `code`) values ('394', 'Europe/Chisinau', 'Europe/Chisinau');
insert into `timezone` (`id`, `name`, `code`) values ('395', 'Europe/Copenhagen', 'Europe/Copenhagen');
insert into `timezone` (`id`, `name`, `code`) values ('396', 'Europe/Dublin', 'Europe/Dublin');
insert into `timezone` (`id`, `name`, `code`) values ('397', 'Europe/Gibraltar', 'Europe/Gibraltar');
insert into `timezone` (`id`, `name`, `code`) values ('398', 'Europe/Guernsey', 'Europe/Guernsey');
insert into `timezone` (`id`, `name`, `code`) values ('399', 'Europe/Helsinki', 'Europe/Helsinki');
insert into `timezone` (`id`, `name`, `code`) values ('400', 'Europe/Isle_of_Man', 'Europe/Isle_of_Man');
insert into `timezone` (`id`, `name`, `code`) values ('401', 'Europe/Istanbul', 'Europe/Istanbul');
insert into `timezone` (`id`, `name`, `code`) values ('402', 'Europe/Jersey', 'Europe/Jersey');
insert into `timezone` (`id`, `name`, `code`) values ('403', 'Europe/Kaliningrad', 'Europe/Kaliningrad');
insert into `timezone` (`id`, `name`, `code`) values ('404', 'Europe/Kiev', 'Europe/Kiev');
insert into `timezone` (`id`, `name`, `code`) values ('405', 'Europe/Lisbon', 'Europe/Lisbon');
insert into `timezone` (`id`, `name`, `code`) values ('406', 'Europe/Ljubljana', 'Europe/Ljubljana');
insert into `timezone` (`id`, `name`, `code`) values ('407', 'Europe/London', 'Europe/London');
insert into `timezone` (`id`, `name`, `code`) values ('408', 'Europe/Luxembourg', 'Europe/Luxembourg');
insert into `timezone` (`id`, `name`, `code`) values ('409', 'Europe/Madrid', 'Europe/Madrid');
insert into `timezone` (`id`, `name`, `code`) values ('410', 'Europe/Malta', 'Europe/Malta');
insert into `timezone` (`id`, `name`, `code`) values ('411', 'Europe/Mariehamn', 'Europe/Mariehamn');
insert into `timezone` (`id`, `name`, `code`) values ('412', 'Europe/Minsk', 'Europe/Minsk');
insert into `timezone` (`id`, `name`, `code`) values ('413', 'Europe/Monaco', 'Europe/Monaco');
insert into `timezone` (`id`, `name`, `code`) values ('414', 'Europe/Moscow', 'Europe/Moscow');
insert into `timezone` (`id`, `name`, `code`) values ('415', 'Europe/Nicosia', 'Europe/Nicosia');
insert into `timezone` (`id`, `name`, `code`) values ('416', 'Europe/Oslo', 'Europe/Oslo');
insert into `timezone` (`id`, `name`, `code`) values ('417', 'Europe/Paris', 'Europe/Paris');
insert into `timezone` (`id`, `name`, `code`) values ('418', 'Europe/Podgorica', 'Europe/Podgorica');
insert into `timezone` (`id`, `name`, `code`) values ('419', 'Europe/Prague', 'Europe/Prague');
insert into `timezone` (`id`, `name`, `code`) values ('420', 'Europe/Riga', 'Europe/Riga');
insert into `timezone` (`id`, `name`, `code`) values ('421', 'Europe/Rome', 'Europe/Rome');
insert into `timezone` (`id`, `name`, `code`) values ('422', 'Europe/Samara', 'Europe/Samara');
insert into `timezone` (`id`, `name`, `code`) values ('423', 'Europe/San_Marino', 'Europe/San_Marino');
insert into `timezone` (`id`, `name`, `code`) values ('424', 'Europe/Sarajevo', 'Europe/Sarajevo');
insert into `timezone` (`id`, `name`, `code`) values ('425', 'Europe/Simferopol', 'Europe/Simferopol');
insert into `timezone` (`id`, `name`, `code`) values ('426', 'Europe/Skopje', 'Europe/Skopje');
insert into `timezone` (`id`, `name`, `code`) values ('427', 'Europe/Sofia', 'Europe/Sofia');
insert into `timezone` (`id`, `name`, `code`) values ('428', 'Europe/Stockholm', 'Europe/Stockholm');
insert into `timezone` (`id`, `name`, `code`) values ('429', 'Europe/Tallinn', 'Europe/Tallinn');
insert into `timezone` (`id`, `name`, `code`) values ('430', 'Europe/Tirane', 'Europe/Tirane');
insert into `timezone` (`id`, `name`, `code`) values ('431', 'Europe/Tiraspol', 'Europe/Tiraspol');
insert into `timezone` (`id`, `name`, `code`) values ('432', 'Europe/Uzhgorod', 'Europe/Uzhgorod');
insert into `timezone` (`id`, `name`, `code`) values ('433', 'Europe/Vaduz', 'Europe/Vaduz');
insert into `timezone` (`id`, `name`, `code`) values ('434', 'Europe/Vatican', 'Europe/Vatican');
insert into `timezone` (`id`, `name`, `code`) values ('435', 'Europe/Vienna', 'Europe/Vienna');
insert into `timezone` (`id`, `name`, `code`) values ('436', 'Europe/Vilnius', 'Europe/Vilnius');
insert into `timezone` (`id`, `name`, `code`) values ('437', 'Europe/Volgograd', 'Europe/Volgograd');
insert into `timezone` (`id`, `name`, `code`) values ('438', 'Europe/Warsaw', 'Europe/Warsaw');
insert into `timezone` (`id`, `name`, `code`) values ('439', 'Europe/Zagreb', 'Europe/Zagreb');
insert into `timezone` (`id`, `name`, `code`) values ('440', 'Europe/Zaporozhye', 'Europe/Zaporozhye');
insert into `timezone` (`id`, `name`, `code`) values ('441', 'Europe/Zurich', 'Europe/Zurich');
insert into `timezone` (`id`, `name`, `code`) values ('442', 'GB-Eire', 'GB-Eire');
insert into `timezone` (`id`, `name`, `code`) values ('443', 'GB', 'GB');
insert into `timezone` (`id`, `name`, `code`) values ('444', 'GMT+0', 'GMT+0');
insert into `timezone` (`id`, `name`, `code`) values ('445', 'GMT-0', 'GMT-0');
insert into `timezone` (`id`, `name`, `code`) values ('446', 'GMT', 'GMT');
insert into `timezone` (`id`, `name`, `code`) values ('447', 'GMT0', 'GMT0');
insert into `timezone` (`id`, `name`, `code`) values ('448', 'Greenwich', 'Greenwich');
insert into `timezone` (`id`, `name`, `code`) values ('449', 'HST', 'HST');
insert into `timezone` (`id`, `name`, `code`) values ('450', 'Hongkong', 'Hongkong');
insert into `timezone` (`id`, `name`, `code`) values ('451', 'Iceland', 'Iceland');
insert into `timezone` (`id`, `name`, `code`) values ('452', 'Indian/Antananarivo', 'Indian/Antananarivo');
insert into `timezone` (`id`, `name`, `code`) values ('453', 'Indian/Chagos', 'Indian/Chagos');
insert into `timezone` (`id`, `name`, `code`) values ('454', 'Indian/Christmas', 'Indian/Christmas');
insert into `timezone` (`id`, `name`, `code`) values ('455', 'Indian/Cocos', 'Indian/Cocos');
insert into `timezone` (`id`, `name`, `code`) values ('456', 'Indian/Comoro', 'Indian/Comoro');
insert into `timezone` (`id`, `name`, `code`) values ('457', 'Indian/Kerguelen', 'Indian/Kerguelen');
insert into `timezone` (`id`, `name`, `code`) values ('458', 'Indian/Mahe', 'Indian/Mahe');
insert into `timezone` (`id`, `name`, `code`) values ('459', 'Indian/Maldives', 'Indian/Maldives');
insert into `timezone` (`id`, `name`, `code`) values ('460', 'Indian/Mauritius', 'Indian/Mauritius');
insert into `timezone` (`id`, `name`, `code`) values ('461', 'Indian/Mayotte', 'Indian/Mayotte');
insert into `timezone` (`id`, `name`, `code`) values ('462', 'Indian/Reunion', 'Indian/Reunion');
insert into `timezone` (`id`, `name`, `code`) values ('463', 'Iran', 'Iran');
insert into `timezone` (`id`, `name`, `code`) values ('464', 'Israel', 'Israel');
insert into `timezone` (`id`, `name`, `code`) values ('465', 'Jamaica', 'Jamaica');
insert into `timezone` (`id`, `name`, `code`) values ('466', 'Japan', 'Japan');
insert into `timezone` (`id`, `name`, `code`) values ('467', 'Kwajalein', 'Kwajalein');
insert into `timezone` (`id`, `name`, `code`) values ('468', 'Libya', 'Libya');
insert into `timezone` (`id`, `name`, `code`) values ('469', 'MET', 'MET');
insert into `timezone` (`id`, `name`, `code`) values ('470', 'MST', 'MST');
insert into `timezone` (`id`, `name`, `code`) values ('471', 'MST7MDT', 'MST7MDT');
insert into `timezone` (`id`, `name`, `code`) values ('472', 'Mexico/BajaNorte', 'Mexico/BajaNorte');
insert into `timezone` (`id`, `name`, `code`) values ('473', 'Mexico/BajaSur', 'Mexico/BajaSur');
insert into `timezone` (`id`, `name`, `code`) values ('474', 'Mexico/General', 'Mexico/General');
insert into `timezone` (`id`, `name`, `code`) values ('475', 'NZ-CHAT', 'NZ-CHAT');
insert into `timezone` (`id`, `name`, `code`) values ('476', 'NZ', 'NZ');
insert into `timezone` (`id`, `name`, `code`) values ('477', 'Navajo', 'Navajo');
insert into `timezone` (`id`, `name`, `code`) values ('478', 'PRC', 'PRC');
insert into `timezone` (`id`, `name`, `code`) values ('479', 'PST8PDT', 'PST8PDT');
insert into `timezone` (`id`, `name`, `code`) values ('480', 'Pacific/Apia', 'Pacific/Apia');
insert into `timezone` (`id`, `name`, `code`) values ('481', 'Pacific/Auckland', 'Pacific/Auckland');
insert into `timezone` (`id`, `name`, `code`) values ('482', 'Pacific/Chatham', 'Pacific/Chatham');
insert into `timezone` (`id`, `name`, `code`) values ('483', 'Pacific/Chuuk', 'Pacific/Chuuk');
insert into `timezone` (`id`, `name`, `code`) values ('484', 'Pacific/Easter', 'Pacific/Easter');
insert into `timezone` (`id`, `name`, `code`) values ('485', 'Pacific/Efate', 'Pacific/Efate');
insert into `timezone` (`id`, `name`, `code`) values ('486', 'Pacific/Enderbury', 'Pacific/Enderbury');
insert into `timezone` (`id`, `name`, `code`) values ('487', 'Pacific/Fakaofo', 'Pacific/Fakaofo');
insert into `timezone` (`id`, `name`, `code`) values ('488', 'Pacific/Fiji', 'Pacific/Fiji');
insert into `timezone` (`id`, `name`, `code`) values ('489', 'Pacific/Funafuti', 'Pacific/Funafuti');
insert into `timezone` (`id`, `name`, `code`) values ('490', 'Pacific/Galapagos', 'Pacific/Galapagos');
insert into `timezone` (`id`, `name`, `code`) values ('491', 'Pacific/Gambier', 'Pacific/Gambier');
insert into `timezone` (`id`, `name`, `code`) values ('492', 'Pacific/Guadalcanal', 'Pacific/Guadalcanal');
insert into `timezone` (`id`, `name`, `code`) values ('493', 'Pacific/Guam', 'Pacific/Guam');
insert into `timezone` (`id`, `name`, `code`) values ('494', 'Pacific/Honolulu', 'Pacific/Honolulu');
insert into `timezone` (`id`, `name`, `code`) values ('495', 'Pacific/Johnston', 'Pacific/Johnston');
insert into `timezone` (`id`, `name`, `code`) values ('496', 'Pacific/Kiritimati', 'Pacific/Kiritimati');
insert into `timezone` (`id`, `name`, `code`) values ('497', 'Pacific/Kosrae', 'Pacific/Kosrae');
insert into `timezone` (`id`, `name`, `code`) values ('498', 'Pacific/Kwajalein', 'Pacific/Kwajalein');
insert into `timezone` (`id`, `name`, `code`) values ('499', 'Pacific/Majuro', 'Pacific/Majuro');
insert into `timezone` (`id`, `name`, `code`) values ('500', 'Pacific/Marquesas', 'Pacific/Marquesas');
insert into `timezone` (`id`, `name`, `code`) values ('501', 'Pacific/Midway', 'Pacific/Midway');
insert into `timezone` (`id`, `name`, `code`) values ('502', 'Pacific/Nauru', 'Pacific/Nauru');
insert into `timezone` (`id`, `name`, `code`) values ('503', 'Pacific/Niue', 'Pacific/Niue');
insert into `timezone` (`id`, `name`, `code`) values ('504', 'Pacific/Norfolk', 'Pacific/Norfolk');
insert into `timezone` (`id`, `name`, `code`) values ('505', 'Pacific/Noumea', 'Pacific/Noumea');
insert into `timezone` (`id`, `name`, `code`) values ('506', 'Pacific/Pago_Pago', 'Pacific/Pago_Pago');
insert into `timezone` (`id`, `name`, `code`) values ('507', 'Pacific/Palau', 'Pacific/Palau');
insert into `timezone` (`id`, `name`, `code`) values ('508', 'Pacific/Pitcairn', 'Pacific/Pitcairn');
insert into `timezone` (`id`, `name`, `code`) values ('509', 'Pacific/Pohnpei', 'Pacific/Pohnpei');
insert into `timezone` (`id`, `name`, `code`) values ('510', 'Pacific/Ponape', 'Pacific/Ponape');
insert into `timezone` (`id`, `name`, `code`) values ('511', 'Pacific/Port_Moresby', 'Pacific/Port_Moresby');
insert into `timezone` (`id`, `name`, `code`) values ('512', 'Pacific/Rarotonga', 'Pacific/Rarotonga');
insert into `timezone` (`id`, `name`, `code`) values ('513', 'Pacific/Saipan', 'Pacific/Saipan');
insert into `timezone` (`id`, `name`, `code`) values ('514', 'Pacific/Samoa', 'Pacific/Samoa');
insert into `timezone` (`id`, `name`, `code`) values ('515', 'Pacific/Tahiti', 'Pacific/Tahiti');
insert into `timezone` (`id`, `name`, `code`) values ('516', 'Pacific/Tarawa', 'Pacific/Tarawa');
insert into `timezone` (`id`, `name`, `code`) values ('517', 'Pacific/Tongatapu', 'Pacific/Tongatapu');
insert into `timezone` (`id`, `name`, `code`) values ('518', 'Pacific/Truk', 'Pacific/Truk');
insert into `timezone` (`id`, `name`, `code`) values ('519', 'Pacific/Wake', 'Pacific/Wake');
insert into `timezone` (`id`, `name`, `code`) values ('520', 'Pacific/Wallis', 'Pacific/Wallis');
insert into `timezone` (`id`, `name`, `code`) values ('521', 'Pacific/Yap', 'Pacific/Yap');
insert into `timezone` (`id`, `name`, `code`) values ('522', 'Poland', 'Poland');
insert into `timezone` (`id`, `name`, `code`) values ('523', 'Portugal', 'Portugal');
insert into `timezone` (`id`, `name`, `code`) values ('524', 'ROC', 'ROC');
insert into `timezone` (`id`, `name`, `code`) values ('525', 'ROK', 'ROK');
insert into `timezone` (`id`, `name`, `code`) values ('526', 'Singapore', 'Singapore');
insert into `timezone` (`id`, `name`, `code`) values ('527', 'Turkey', 'Turkey');
insert into `timezone` (`id`, `name`, `code`) values ('528', 'UCT', 'UCT');
insert into `timezone` (`id`, `name`, `code`) values ('529', 'US/Alaska', 'US/Alaska');
insert into `timezone` (`id`, `name`, `code`) values ('530', 'US/Aleutian', 'US/Aleutian');
insert into `timezone` (`id`, `name`, `code`) values ('531', 'US/Arizona', 'US/Arizona');
insert into `timezone` (`id`, `name`, `code`) values ('532', 'US/Central', 'US/Central');
insert into `timezone` (`id`, `name`, `code`) values ('533', 'US/East-Indiana', 'US/East-Indiana');
insert into `timezone` (`id`, `name`, `code`) values ('534', 'US/Eastern', 'US/Eastern');
insert into `timezone` (`id`, `name`, `code`) values ('535', 'US/Hawaii', 'US/Hawaii');
insert into `timezone` (`id`, `name`, `code`) values ('536', 'US/Indiana-Starke', 'US/Indiana-Starke');
insert into `timezone` (`id`, `name`, `code`) values ('537', 'US/Michigan', 'US/Michigan');
insert into `timezone` (`id`, `name`, `code`) values ('538', 'US/Mountain', 'US/Mountain');
insert into `timezone` (`id`, `name`, `code`) values ('539', 'US/Pacific', 'US/Pacific');
insert into `timezone` (`id`, `name`, `code`) values ('540', 'US/Samoa', 'US/Samoa');
insert into `timezone` (`id`, `name`, `code`) values ('541', 'UTC', 'UTC');
insert into `timezone` (`id`, `name`, `code`) values ('542', 'Universal', 'Universal');
insert into `timezone` (`id`, `name`, `code`) values ('543', 'W-SU', 'W-SU');
insert into `timezone` (`id`, `name`, `code`) values ('544', 'WET', 'WET');
insert into `timezone` (`id`, `name`, `code`) values ('545', 'Zulu', 'Zulu');

drop table if exists `users`;
; 

drop table if exists `weekdays`;
; 
