<?
class cls_language
{
	function define_lng_var()
	{
		$db = new Db();

		$qry = "select * from label_values";
		$lng_list = $db->runQuery($qry);
		foreach($lng_list as $lnglst)
		{
			define($lnglst['lb'], $lnglst['ar_value']);
		}
/*define('LNG_CHANGE_LANG', 'Change Language');
define('LNG_NEW', 'New');
define('LNG_HOME', 'Home');
define('LNG_ADD', 'Add');
define('LNG_EDIT', 'Edit');
define('LNG_DELETE', 'Delete');
define('LNG_ENABLE', 'Enable');
define('LNG_DISABLE', 'Disable');
define('LNG_SAVE', 'Save');
define('LNG_SUBMIT', 'Submit');
define('LNG_REPLY', 'Reply');
define('LNG_SAVE_AND_PROCEED', 'Save & Proceed');
define('LNG_SUBMIT', 'Finish');
define('LNG_GO', 'Go');
define('LNG_VIEW', 'View');
define('LNG_CREATE', 'Create');
define('LNG_UPDATE', 'Update');
define('LNG_SHOW', 'Show');
define('LNG_NAME', 'Name');
define('LNG_START_DATE', 'Start date');
define('LNG_END_DATE', 'End date');
define('LNG_CONFIGURATION', 'Configuration');
define('LNG_CONFIGURATION_HOME', 'Configuration Home');
define('LNG_BATCHES', 'Classes');
define('LNG_MANAGE_BATCHES', 'Manage Classes');
define('LNG_BATCH', 'Class');
define('LNG_BATCH_NAME', 'Class Name');
define('LNG_NEW_BATCH', 'New Class');
define('LNG_SELECT_A_BATCH', 'Select a class');
define('LNG_ACTIVE_BATCHES', 'Active Classes');
define('LNG_EDIT_BATCHES', 'Edit Class');
define('LNG_NO_BATCHES_AVAILABLE', 'No Class Available.');
define('LNG_CODE', 'Code');
define('LNG_GRADES', 'Grades');
define('LNG_NEWGRADES', 'New Grades');
define('LNG_GRADE_NAME', 'Grade Name');
define('LNG_MANAGE_GRADE', 'Manage Grade');
define('LNG_SELECT_A_GRADE', 'Select a grade');
define('LNG_MANAGE_GRADES', 'Manage Grades');
define('LNG_SELECT_GRADE', 'Select a grade:');
define('LNG_MANAGE_GRADES_BATCHES', 'Manage Grades / Classes');
define('LNG_ADDNEW_COURSE_OR_BATCH', 'Add a new Grades or Classes for this academic year.');
define('LNG_MANAGE_CREATE_GRADES', 'Manage Grades and create grades');
define('LNG_MANAGE_BATCHES', 'Manage Classes');
define('LNG_MANAGE_ACTIVE_BATCHES', 'Manage Active Classes');
define('LNG_GRADES_S', 'grades');
define('LNG_GRADE', 'Grade');
define('LNG_SUBJECT', 'Course');
define('LNG_SELECT_A_SUBJECT', 'Select a Course');
define('LNG_SUBJECTS', 'Courses');
define('LNG_ADD_SUBJECT', 'Add Course');
define('LNG_ADD_SUBJECTS', 'Add Courses');
define('LNG_SELECT_SUBJECTS', 'Select Courses');
define('LNG_ADD_NEW_SUBJECT', 'Add New Course');
define('LNG_MANAGE_SUBJECTS', 'Manage Courses');
define('LNG_MANAGE_SUBJECTS_CORRESPONDING_TO_GRADES', 'Manage courses corresponding to different grades.');
define('LNG_SLNO', 'Sl.no');
define('LNG_ADMISSION_NO', 'Admission Number');
define('LNG_STUDENT_ADMISSION_NO', 'Student Admission Number');
define('LNG_ADM_NO', 'Adm No.');
define('LNG_VIEW_PROFILE', 'View Profile');
define('LNG_STUDENT_DETAILS', 'Student Details');
define('LNG_VIEW_DETAILS', 'View Details');
define('LNG_INITIAL_BATCH_DETAIL', 'Initial batch details');
define('LNG_STUDENTS', 'Students');
define('LNG_REPORTS_CENTER', 'Reports center');
define('LNG_ACADEMICS', 'Academics');
define('LNG_RECENT_EXAMS', 'Recent exams');
define('LNG_SUBJECTWISE_RESULTS', 'Coursewise results');
define('LNG_DETAILED_REPORTS', 'Detailed reports');
define('LNG_CURRENT_YEAR_REPORTS', 'Current year reports');
define('LNG_STUDENT_INFO', 'Student Info');
define('LNG_STUDENT_PROFILE', 'Student Profile');
define('LNG_GUARDIANS', 'Guardians');
define('LNG_ADMISSION_DATE', 'Admission Date');
define('LNG_DOB', 'Date of birth');
define('LNG_NATIONALITY', 'Nationality');
define('LNG_RELIGION', 'Religion');
define('LNG_ADDRESS', 'Address');
define('LNG_PHONE', 'Phone');
define('LNG_PHONENO', 'Phone No');
define('LNG_PARENTS_INFO', 'Parent Information');
define('LNG_EDIT_DETAILS', 'Edit details');
define('LNG_STUDENT_DETAILS', 'Student details');
define('LNG_STEP_1_STUDENT_DETAILS', 'Step 1 - Student details');
define('LNG_STEP_2_PARENT_DETAILS', 'Step 2 - Parent/guardian details');
define('LNG_ADMISSION', 'Admission');
define('LNG_EDIT_PARENT_DETAIL', 'Edit Parent/guardian details');
define('LNG_PARENTS_GUARDIANS', 'Parents/Guardian');
define('LNG_RELATION', 'Relation');
define('LNG_USERNAME', 'Username');
define('LNG_PASSWORD', 'Password');
define('LNG_PARENT_PERSONAL_DETAIL', 'Parent - Personal Details');
define('LNG_FIRST_NAME', 'First Name');
define('LNG_MIDDLE_NAME', 'Middle Name');
define('LNG_LAST_NAME', 'Last Name');
define('LNG_RELATIONSHIP', 'Relationship');
define('LNG_UPLOAD_PARENT_ID_CARD', 'Upload Parent ID Card photo');
define('LNG_PARENT_USERNAME', 'Parent Username');
define('LNG_PARENT_PASSWORD', 'Parent Password');
define('LNG_FIELDS_MARKED_WITH', 'Fields marked with');
define('LNG_MUST_BE_FILLED', 'must be filled.');
define('LNG_PERSONAL_DETAIL', 'Personal Details');
define('LNG_PASSPORT_OR_ID', 'Pasport / ID Card');
define('LNG_ID', 'ID');
define('LNG_PASSPORT', 'Passport');
define('LNG_TITLE', 'Title');
define('LNG_SENT_ON', 'Sent on');
define('LNG_GRADE_AND_BATCH', 'Grade & Class');
define('LNG_CONTACT_DETAILS', 'Contact Details');
define('LNG_UPLOAD_USER_PHOTO', 'Upload User Photo');
define('LNG_UPLOAD_PHOTO', 'Upload photo (250KB max)');
define('LNG_UPLOAD_BIRTH_CERTIFICATE', 'Upload Birth Certificate photo');
define('LNG_MESSAGE_STUDENT_RECORD_SAVED', 'Student Record Saved Successfully. Please fill the Parent Details.');
define('LNG_ATTENDANCE', 'Attendance');
define('LNG_ATTENDANCE_HOME', 'Attendance Home');
define('LNG_ATTENDANCE_REGISTER', 'Attendance Register');
define('LNG_ATTENDANCE_REGISTER_FOR_STUDENTS', 'Attendance register for students');
define('LNG_MANAGE_ATTENDANCE_REGISTER', 'Manage Attendance Register');
define('LNG_CREATE_UPDATE_ATTENDANCE_REGISTER', 'Create and update attendance register');
define('LNG_ATTENDANCE_REPORT', 'Attendance Report');
define('LNG_ATTENDANCE_REPORT_OF_STUDENTS', 'Attendance report of students');
define('LNG_REASON_FOR_ABSENCE', 'Reason for absence');
define('LNG_ATTENDANCE_FOR', 'Attendance for');
define('LNG_FROM', 'From :');
define('LNG_TO', 'To :');
define('LNG_PUBLISH_REGISTER', 'Publish Register');
define('LNG_EVENTS', 'Events');
define('LNG_EXAMINATIONS', 'Examinations');
define('LNG_HOLIDAYS', 'Holidays');
define('LNG_SUNDAY', 'Sunday');
define('LNG_MONDAY', 'Monday');
define('LNG_TUESDAY', 'Tuesday');
define('LNG_WEDNESDAY', 'Wednesday');
define('LNG_THURSDAY', 'Thursday');
define('LNG_FRIDAY', 'Friday');
define('LNG_SATURDAY', 'Saturday');
define('LNG_IS_HOLIDAY', 'Is Holiday?');
define('LNG_COMMON', 'Common');
define('LNG_EVENT_COMMON_TO_ALL', 'Event common to all');
define('LNG_CREATE_EVENT', 'Create Event');
define('LNG_UPDATE_EVENT', 'Update Event');
define('LNG_STEP1_EVENT_CREATE', 'Step 1 - Event creation');
define('LNG_STEP2_CONFIRMATION', 'Step 2 - Confirmation');
define('LNG_SEPERATOR_1', ':');
define('LNG_SEPERATOR_2', '-');
define('LNG_DESCRIPTION', 'Description');
define('LNG_OTHER_EVENTS', 'Other Events');
define('LNG_THIS_EVENT_IS_COMMON_ACROSS_ALL_CLASSES', 'This event is common across all classes');
define('LNG_COURSES_ASSOCIATED', 'Courses Associated');
define('LNG_NO_CLASS_SELECTED_FOR_THIS_EVENT', 'No class selected for this event yet');
define('LNG_SELECT_MORE_COURSES', 'Select more Courses');
define('LNG_REMOVE', 'Remove');
define('LNG_CANCEL', 'Cancel');
define('LNG_WELCOME_MESSAGE1', 'Welcome');
define('LNG_WELCOME_MESSAGE2', 'to My School dashboard');
define('LNG_ADD_SCHOOL', 'Add School');
define('LNG_STEP1_SCHOOL_DETAILS', 'Step 1 - School details');
define('LNG_SCHOOL_NAME', 'School/College Name');
define('LNG_SCHOOL_ADDRESS', 'School/College Address');
define('LNG_SCHOOL_PHONE', 'School/College Phone');
define('LNG_SCHOOL_FAX_NO', 'School/College Fax No.');
define('LNG_UPLOAD_LOGO', 'Upload Logo');
define('LNG_SCHOOL_DETAILS', 'School Details');
define('LNG_VIEW_SCHOOLS', 'View Schools');
define('LNG_ADD_SECRETARY', 'Add Secretary');
define('LNG_MANAGE_SECRETARY', 'Manage Secretary');
define('LNG_MY_PROFILE', 'My Profile');
define('LNG_TIMETABLE', 'Timetable');
define('LNG_SETTINGS', 'Settings');
define('LNG_MANAGE_EMPLOYEE', 'Manage Employee');
define('LNG_CREATE_EDIT_TIMETABLE', 'Create/Edit Timetable');
define('LNG_TIMETABLE_TEXT2', 'Select a class and edit the timetable for that class.');
define('LNG_SET_CLASS_TIMINGS', 'Set class timings');
define('LNG_TIMETABLE_TEXT3', 'Select a class and edit the timetable for that class.');
define('LNG_VIEW_TIMETABLE', 'View Timetables');
define('LNG_TIMETABLE_TEXT4', 'View the timetable for a class.');
define('LNG_CREATE_WEEKDAYS', 'Create weekdays');
define('LNG_SELECT_CLASS_TO_EDIT', 'Select class to edit');
define('LNG_EDIT_BATCH', 'Edit Class');
define('LNG_ADD_SUBJECTS_EMPLOYEE', 'Add Subjects/Employee');
define('LNG_SET_IN_COMMON', 'Set in common');
define('LNG_START_TIME', 'Start time');
define('LNG_END_TIME', 'End time');
define('LNG_OPERATIONS', 'Operations');
define('LNG_IS_A_BREAK', 'Is a break');
define('LNG_EDIT_CLASSTIMINGS_FOR', 'Edit class timing for');
define('LNG_ADD_NEW_CLASSTIMINGS_FOR', 'Add new class timing for');
define('LNG_SELECT_BATCH_TO_VIEW', 'Select class to view');
define('LNG_WEEKDAYS', 'Weekdays');
define('LNG_TEACHER', 'Teacher');
define('LNG_EMPLOYEE_SETTINGS', 'Employee settings.');
define('LNG_EMPLOYEE_MANAGEMENT', 'Employee Management');
define('LNG_MANAGE_ALL_EMPLOYEE', 'Manage all employees');
define('LNG_EMPLOYEE_LIST', 'Employee List');
define('LNG_SEARCH_FOR_EMPLOYEES', 'Search for employees');
define('LNG_ADD_EMP_CATEGORY', 'Add employee category');
define('LNG_EMP_TEXT2', 'Add and edit employee category.');
define('LNG_ADD_EMP_POSITION', 'Add employee position');
define('LNG_EMP_TEXT3', 'Add and edit employee position.');
define('LNG_ADD_EMP_DEPT', 'Add employee department');
define('LNG_EMP_TEXT4', 'Add and edit employee department.');
define('LNG_PREFIX', 'Prefix');
define('LNG_STATUS', 'Status');
define('LNG_ACTIVE_CATEGORIES', 'Active Categories');
define('LNG_INACTIVE_CATEGORIES', 'Inactive Categories');
define('LNG_EMP_CATEGORY', 'Employee category');
define('LNG_ACTIVE_POSITIONS', 'Active Positions');
define('LNG_INACTIVE_POSITIONS', 'Inactive Positions');
define('LNG_DEPT_CODE', 'Dept. code');
define('LNG_ACTIVE_DEPARTMENTS', 'Active Departments');
define('LNG_INACTIVE_DEPARTMENTS', 'Inactive Departments');
define('LNG_EMP_ADMISSION', 'Employee admission');
define('LNG_EMP_ADMISSION_FORM', 'Employee admissions form');
define('LNG_EMP_SUBJECT_ASSOCIATION', 'Employee Subject Association');
define('LNG_EMP_TEXT5', 'Assign an employee with one or more subjects');
define('LNG_EMP_CLASS_ASSOCIATION', 'Employee Class Association');
define('LNG_EMP_TEXT6', 'Assign an employee with one or more class');
define('LNG_STEP1', 'Step-1');
define('LNG_GENERAL_DETAILS', 'General Details');
define('LNG_EMP_NO', 'Employee no.');
define('LNG_JOINING_DATE', 'Joining date.');
define('LNG_GENDER', 'Gender');
define('LNG_DEPT', 'Department');
define('LNG_CATEGORY', 'Category');
define('LNG_POSITION', 'Position');
define('LNG_QUALIFICATION', 'Qualification');
define('LNG_EXP_INFO', 'Experience Info');
define('LNG_TOTAL_EXP', 'Total Experience');
define('LNG_MARTIAL_STATUS', 'Marital status');
define('LNG_NO_OF_CHILD', 'No of children');
define('LNG_FATHER_NAME', 'Father name');
define('LNG_MOTHER_NAME', 'Mother name');
define('LNG_SPOUSE_NAME', 'Spouse name');
define('LNG_BLOOD_GROUP', 'Blood group');
define('LNG_STEP2', 'Step-2');
define('LNG_HOME_ADDRESS', 'Home Address');
define('LNG_LINE1', 'Line 1');
define('LNG_LINE2', 'Line 2');
define('LNG_CITY', 'City');
define('LNG_STATE', 'State');
define('LNG_COUNTRY', 'Country');
define('LNG_PIN', 'PIN');
define('LNG_OFFICE_ADDRESS', 'Office Address');
define('LNG_SKIP_THIS_STEP', 'Skip This Step');
define('LNG_EMP_RECORD_SAVED', 'Employee record saved');
define('LNG_EMP_PROFILE', 'Employee Profile');
define('LNG_DETAILS', 'Details');
define('LNG_PROFILE', 'Profile');
define('LNG_GENERAL', 'General');
define('LNG_PERSONAL', 'Personal');
define('LNG_ADDRESS', 'Address');
define('LNG_YEARS', 'Years');
define('LNG_MONTHS', 'Months');
define('LNG_EDIT_EMP_INFO', 'Edit employee information');
define('LNG_EMPLOYEE_SUBJECT', 'Employee Subject');
define('LNG_ASSOCIATE', 'Associate');
define('LNG_EMPLOYEE_CLASS', 'Employee Class');
define('LNG_EMPLOYEES', 'Employees');
define('LNG_CURRENTLY_ASSIGNED', 'Currently assigned:');
define('LNG_NO_EMPLYEES_ASSIGNED', 'No employee assigned yet.');
define('LNG_SELECT_DEPARTMENT', 'Select department');
define('LNG_NO_EMPLOYEES_IN_DEPARTMENT', 'No employee in this department.');
define('LNG_ASSIGN_NEW', 'Assign new:');
define('LNG_ASSIGN', 'Assign');
define('LNG_VIEW_ALL', 'View all');
define('LNG_VIEW_ALL_S', 'view all');
define('LNG_SELECT_A_DEPARTMENT', 'Select a Department :');
define('LNG_SELECT_EMPLOYEE', 'Select Employee');
define('LNG_EXAMS', 'Exams');
define('LNG_EXAM', 'Exam');
define('LNG_SET_GRADING_LEVELS', 'Set grading levels');
define('LNG_EXAM_TXT2', 'Set the Grading Levels');
define('LNG_EXAM_MANAGEMENT', 'Exam Management');
define('LNG_EXAM_TXT3', 'Create new exams, enter results.');
define('LNG_EXAM_WISE_REPORT', 'Exam Wise report');
define('LNG_EXAM_TXT4', 'Generates reports Exam wise');
define('LNG_SUBJECT_WISE_REPORT', 'Subject Wise report');
define('LNG_EXAM_TXT5', 'Generates reports Subject wise');
define('LNG_GROUPED_EXAM_REPORT', 'Grouped Exam report');
define('LNG_EXAM_TXT6', 'Group up exams for specific reports');
define('LNG_GRADING_LEVELS', 'Grading levels');
define('LNG_ADD_GRADES', 'Add Grades');
define('LNG_MIN_SCORE', 'Min score');
define('LNG_ADD_NEW_GRADING_LEVEL', 'Add new grading level');
define('LNG_MIN_SCORE_FOR_THIS_GRADE', 'Min score for this grade');
define('LNG_EDIT_GRADING_LEVEL', 'Edit grading level');
define('LNG_CREATE_EXAM', 'Create Exam');
define('LNG_EXAM_GROUPS', 'Exam groups');
define('LNG_CONNECT_EXAMS', 'Connect exams');
define('LNG_EXAM_NAME', 'Exam name');
define('LNG_ACTION', 'Action');
define('LNG_EXAM_RESULT_PUBLISHED', 'Exam result published.');
define('LNG_SCHEDULED_PUBLISHED', 'Schedule published.');
define('LNG_PUBLISH_EXAM_RESULT', 'Publish Exam Result');
define('LNG_PUBLISH_EXAM_SCHEDULE', 'Publish Exam Schedule');
define('LNG_SHOWING_EXAM_GROUPS', 'Showing Exam groups');
define('LNG_MAX_MARKS', 'Max marks');
define('LNG_MIN_MARKS', 'Min marks');
define('LNG_MANAGE', 'Manage');
define('LNG_EDIT_EXAM', 'Edit Exam');
define('LNG_FOR_EXAM_GROUP', 'For exam group');
define('LNG_MAXIMUM_MARKS', 'Maximum Marks');
define('LNG_MINIMUM_MARKS', 'Minimum Marks');
define('LNG_RESULT_ENTRY', 'Result Entry');
define('LNG_MARKS', 'Marks');
define('LNG_REMARKS_ETC', 'Remarks(absent/disqualified etc)');
define('LNG_NEW_EXAM', 'New Exam');
define('LNG_EXAM_TYPE', 'Exam Type');
define('LNG_MARKS_AND_GRADES', 'MarksAndGrades');
define('LNG_SELECT_EXAM_GROUP', 'Select exam group');
define('LNG_GENERATED_REPORT', 'Generated Report');
define('LNG_CONSOLIDATED_REPORT', 'Consolidated Report');
define('LNG_OBTAINED_MARKS', 'Obtained Marks');
define('LNG_PERCENTAGE', 'Percentage(%)');
define('LNG_TOTAL_MARKS', 'Total Marks:');
define('LNG_BATCH_AVERAGE_MARKS', 'Class Average Marks');
define('LNG_BATCH_AVERAGE_PERCENT', 'Class Average %');
define('LNG_SUBJECT_WISE_REPORT', 'Subject wise Reports');
define('LNG_GROUPING', 'Grouping');
define('LNG_GROUPED_EXAM_REPORT', 'Grouped exam Reports');
define('LNG_NO_RECORD_AVAILABLE', 'No Recored Available.');
define('LNG_TOTAL', 'Total');
define('LNG_AGGREGATE_PERCENT', 'Aggregate %');
define('LNG_ENTER_EXAM_RELATED_DETAIL', 'Enter exam related details here:');
define('LNG_SUBJECT_NAME', 'Course name');
define('LNG_DO_NOT_CREATE', 'Do not create');
define('LNG_SAVE_CHANGES', 'Save Changes');
define('LNG_PUBLISH_RESULT', 'Publish Result');
define('LNG_QUESTIONAIRE', 'Questionaire');
define('LNG_GENERAL_LIST', 'General List');
define('LNG_ARCHIVE_LIST', 'Archive List');
define('LNG_ACTIVE_LIST', 'Active List');
define('LNG_SUMMARY', 'Summary');
define('LNG_FULL_DESCRIPTION', 'Full Description :');
define('LNG_DATE', 'Date');
define('LNG_FINAL_REPORT_EXAM_GROUPED', 'Final Report(Exams Grouped)');
define('LNG_COMPARE_WITH_PAST_YEARS', 'Compare with past years (Exams Grouped)');
define('LNG_TEACHER_TIMETABLE', 'Teacher Time-table');
define('LNG_CREATE_SECRETARY', 'Create Secretary');
define('LNG_ADD_NEW_SECRETARY', 'Add new Secretary');
define('LNG_EMAIL', 'Email');
define('LNG_SCHOOL', 'School');
define('LNG_DETAILS_ABOUT_SECRETARY', 'Details about Secretaries');
define('LNG_ADD_NEW', 'Add new');
define('LNG_SEARCH_SECRETARY', 'Search Secretaries');
define('LNG_ALL_USERS', 'All Users');
define('LNG_SECRETARY_PROFILE', 'Secretary Profile');
define('LNG_SECRETARY_INFORMATION', 'Secretary Information');
define('LNG_CHANGE_PASSWORD', 'Change Password');
define('LNG_SCHOOL', 'School');
define('LNG_EDIT_PROFILE', 'Edit Profile');
define('LNG_DETAILS_ABOUT_USERS', 'Details about users');
define('LNG_SELECT_A_SCHOOL', 'Select a School');
define('LNG_REMOVE_STUDENT', 'Remove student');
define('LNG_STUDENT_LEAVING_INSTITUTE', 'Student leaving Institution');
define('LNG_REMOVE_STUDENT_TEXT1', 'For students leaving the Institution, use this option to remove them from the list of active students and place them in the former students list.');
define('LNG_REMOVE_STUDENT_RECORDS', 'Remove student records');
define('LNG_ID', 'Completely delete student\'s records from the Institution\'s databases. Use this option only if you created the student record by accident and want to remove it completely.');
define('LNG_REMOVE_STUDENT_TEXT2', 'Completely delete student\'s records from the Institution\'s databases. Use this option only if you created the student record by accident and want to remove it completely.');
define('LNG_LEAVING_SCHOOL', 'Leaving school');
define('LNG_REASON_FOR_LEAVING', 'Reason for leaving');
define('LNG_BATCH_TEACHER', 'Class Teacher');
define('LNG_COMMENTS', 'Comments');
define('LNG_UPDATE_SECRETARY', 'Update Secretary');
define('LNG_EDIT_SECRETARY', 'Edit Secretary');
define('LNG_EDIT_USER', 'Edit User');
define('LNG_UPDATE_USER_INFO', 'Update user information');
define('LNG_NEW_PASSWORD', 'New password');
define('LNG_CONFIRM_PASSWORD', 'Confirm password');
define('LNG_UPDATE_SCHOOL', 'Update School');
define('LNG_UPDATE_SCHOOL_DETAILS', 'Update School Details');
define('LNG_ADMINISTRATOR', 'Administrator');
define('LNG_INFORMATION', 'Information');
define('LNG_UPDATE_DETAILS', 'Update Details');
define('LNG_PRESENT_STUDENTS', 'Present Students');
define('LNG_FORMER_STUDENTS', 'Former Students');
define('LNG_CALENDER', 'Calender');
define('LNG_EMPLOYEE_SEARCH', 'Employee search');
define('LNG_EMPLOYEE_DETAILS', 'Employee Details');
define('LNG_SEARCH', 'Search');
define('LNG_SELECT_CATEGORY', 'Select category');
define('LNG_SELECT_POSITION', 'Select position');
define('LNG_POST_A_COMMENT', 'Post a Comment');
define('LNG_MESSAGES', 'Messages');
define('LNG_MESSAGE', 'Message');
define('LNG_LOGOUT', 'Log out');
define('LNG_DASHBOARD', 'Dashboard');
define('LNG_MANAGE_SCHOOLS', 'Manage Schools');
define('LNG_POWERED_BY', 'Powered by');
define('LNG_STUDENTS', 'Students');
define('LNG_SUBJECTS_TEMPLATE', 'Courses Template');
define('LNG_MANAGE_TEMPLATE', 'Manage template');
define('LNG_MANAGE_SUBJECTS_TEMPLATE', 'Manage Courses Template');
define('LNG_ACTIVE_SUBJECTS', 'Active Courses');
define('LNG_ADD_SUBJECTS_TEMP', 'Add Courses Template');
define('LNG_SESSION_START_YEAR', 'Session Start Year');
define('LNG_SELECT_A_RELIGION', 'Select a Religion');
define('LNG_ADVANCE_SEARCH', 'Advance Search');
define('LNG_TOTAL_NO_OF_WORK_DAYS', 'Total no. of working days =');
define('LNG_SELECT_MONTH_AND_YEAR', 'Select month & year :');
define('LNG_SELECT_A_MONTH', 'Select a month');
define('LNG_SELECT_A_MODE', 'Select a mode:');
define('LNG_MONTHLY', 'Monthly');
define('LNG_OVERALL', 'Overall');
define('LNG_BIRTH_DATE', 'Birth date');
define('LNG_STUDENT', 'Student');
define('LNG_DEPARTMENT', 'Department');
define('LNG_KEYWORD', 'Keyword');
define('LNG_FILTER', 'Filter');
define('LNG_TO_S', 'to');
define('LNG_ADVANCE_SEARCH_DETAILS', 'Advance Search Details');
define('LNG_SIMPLE_SEARCH', 'Simple Search');
define('LNG_CREATE_NEW', 'Create New');
define('LNG_CREATE_REMINDER_TO_STAFF', 'Create reminder to a staff');
define('LNG_SELECT_MANAGEMENT', 'Select Managements');
define('LNG_SUPER_ADMIN', 'Super Administrator');
define('LNG_SELECT_STAFF_NAME', 'Select Staff Name');
define('LNG_CREATE_REMINDER_TO_GUARDIAN', 'Create reminder to a student\'s guardians');
define('LNG_SENT', 'Sent');
define('LNG_INBOX', 'Inbox');
define('LNG_CREATE_TICKET_TO_STAFF', 'Create Ticket to Staff');
define('LNG_CREATE_TICKET_TO_GUARDIAN', 'Create ticket to a student');
define('LNG_ID', 'ID');
define('LNG_ID', 'ID');
define('LNG_ID', 'ID');

			

define('LNG_BATCH_SAVED', 'Class has been saved.');
define('LNG_BATCH_UPDATED', 'Class updated successfully.');
define('LNG_BATCH_DELETED', 'Class deleted successfully.');
define('LNG_STUDENT_CATEGORY_SAVED', 'Student category has been saved.');
define('LNG_EVENT_UPDATED', 'Event Updated Sucessfully');
define('LNG_EXAM_CREATED', 'Exam created successfully.');
define('LNG_EXAM_GROUPED', 'Exam grouped successfully.');
define('LNG_EXAM_UPDATED', 'Exam updated successfully.');
define('LNG_EXAM_SCORES_UPDATED', 'Exam scores updated.');
define('LNG_GRADE_UPDATED', 'GRADE updated successfully.');
define('LNG_GRADE_CREATED', 'Created grades successfully.');
define('LNG_GRADE_DELETED', 'GRADE has been deleted successfully');
define('LNG_INVALID_EMAILID_PASSWORD', 'Invalid emailid or password.');
define('LNG_YOU_ARE_LOGGED_OUT', 'You are logged out successfully.');
define('LNG_SCHOOL_ADDED', 'School addded successfully.');
define('LNG_SCHOOL_UPDATED', 'School information updated successfully.');
define('LNG_STUDENT_ADDED', 'Student admission successfully.');
define('LNG_STUDENT_UPDATED', 'Student details updated successfully.');
define('LNG_STUDENT_NOT_ADDED', 'Student admission not successful.');
define('LNG_STUDENT_GUARDIAN_DETAIL_UPDATED', 'Student guardian detail updated successfully.');
define('LNG_STUDENT_CATEGORY_DELETED', 'Student category has been deleted.');
define('LNG_STUDENT_CATEGORY_UPDATED', 'Student category has been updated.');
define('LNG_STUDENT_CATEGORY_SAVED', 'Student category has been saved.');
define('LNG_SECRETARY_ADDED', 'Secretary addded successfully.');
define('LNG_SECRETARY_UPDATED', 'Secretary updated successfully.');
define('LNG_WEEKDAY_UPDATED', 'Weekday updated successfully.');
define('LNG_EMPLOYEE_CATEGORY_ADDED', 'Employee category added successfully');
define('LNG_EMPLOYEE_CATEGORY_UPDATED', 'Employee category updated sucessfully');
define('LNG_EMPLOYEE_CATEGORY_DELETED', 'Employee category deleted sucessfully');
define('LNG_EMPLOYEE_DEPARTMENT_ADDED', 'Employee department added sucessfully');
define('LNG_EMPLOYEE_DEPARTMENT_UPDATED', 'Employee department updated successfully');
define('LNG_EMPLOYEE_DEPARTMENT_DELETED', 'Employee department deleted successfully');
define('LNG_EMPLOYEE_POSITION_ADDED', 'Employee position added successfully');
define('LNG_EMPLOYEE_POSITION_UPDATED', 'Employee position updated successfully');
define('LNG_EMPLOYEE_POSITION_DELETED', 'Employee position deleted successfully');
define('LNG_EMPLOYEE_ADDED', 'Employee added successfully');
define('LNG_EMPLOYEE_PRIVILEGES_UPDATED', 'Employee privileges updated sucessfully');
define('LNG_NO_EMPLOYEE_IN_THIS_DEPARTMENT', 'No Employee in the selected department');
define('LNG_NO_STUDENTS_IN_SELECTED_BATCH', 'No Students in selected class');
define('LNG_ID', 'ID');*/
	}
}

?>