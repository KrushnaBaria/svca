<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('/process', 'Login::process');
//$routes->get('/dashboard', 'Home::index');
$routes->post('/adduser', 'AddUserController::register');

service('auth')->routes($routes);

//$routes->get('/', 'Dashboard::index');

$routes->group('dashboard', function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->post('get-main-report-chart-data', 'Dashboard::getMainReportChartData');
    $routes->post('get-PRE', 'Dashboard::get_PRE');
    $routes->post('get-student-count', 'Dashboard::get_Student_Count');
});


$routes->group('statistics', function ($routes){
    $routes->get('/', 'Statistics::index');
    $routes->post('get-revenue', 'Statistics::getRevenue');
    $routes->post('get-expense', 'Statistics::getExpense');
    $routes->post('get-profit', 'Statistics::getProfit');
});

$routes->group('profit-share', function ($routes) {
    $routes->get('/', 'ProfitShare::index');
    $routes->post('get-total-profit', 'ProfitShare::getTotalProfit');
});

$routes->group('expense', function ($routes) {
    $routes->get('/', 'Expense::index');
    $routes->post('add', 'Expense::add');
    $routes->post('list', 'Expense::list');
    $routes->post('import-csv', 'Expense::importCsv');
});

$routes->group('student', function ($routes) {
    $routes->get('/', 'Student::index');
    $routes->post('add', 'Student::add');
    $routes->get('list', 'Student::list');
    $routes->get('export', 'Student::export');
    $routes->get('import', 'Student::importForm');
    $routes->post('import-csv', 'Student::importCsv');
    $routes->get('edit/(:num)', 'Student::edit/$1');
    $routes->get('view/(:num)', 'Student::view/$1');
    $routes->post('getStudents', 'Student::getStudents');
    $routes->post('update-del-sts', 'Student::update_delete_sts');
    $routes->get('birthday-buzz', 'Student::birthdayBuzz');
    $routes->post('get-stu-birthday', 'Student::getStuBirthday');
    $routes->post('mark-as-old', 'Student::markAsOld');
    $routes->post('withdraw', 'Student::withdraw');
});

$routes->group('esamaj', function ($routes) {
    $routes->get('list', 'Esamaj::list');
    $routes->post('get-list', 'Esamaj::get_list');
});

$routes->group('inquery', function ($routes) {
    $routes->get('/', 'Inquery::index');
    $routes->post('add', 'Inquery::add');
    $routes->post('list', 'Inquery::list');
    $routes->post('admit', 'Inquery::admit');
    $routes->post('update-del-sts', 'Inquery::update_delete_sts');
    $routes->post('recent-list', 'Inquery::recent_list');
    $routes->get('follow-up/(:num)', 'Inquery::followUp/$1');
    $routes->post('add-follow-up', 'Inquery::addFollowUp');
    $routes->post('follow-up-list', 'Inquery::followUpList');
    $routes->post('today-follow-up', 'Inquery::todayFollowUp');
});

$routes->group('settings', function ($routes) {
    $routes->get('/', 'Settings::index');
    $routes->post('add-center', 'Settings::addCenter');
    $routes->post('getCenters', 'Settings::getCenters');
    $routes->post('add-course', 'Settings::addCourse');
    $routes->post('getCourses', 'Settings::getCourses');
    $routes->post('update-course', 'Settings::updateCouse');
    $routes->post('add-district', 'Settings::addDidtrict');
    $routes->post('get-districts', 'Settings::getDistricts');
    $routes->post('delete-center', 'Settings::deleteCenter');
    $routes->post('delete-course', 'Settings::deleteCourse');
    $routes->post('delete-district', 'Settings::deleteDistrict');
});

$routes->group('course', function ($routes) {
    //$routes->get('/', 'Course::index');
    //$routes->post('add', 'Course::add');
    //$routes->post('list', 'Course::list');
    $routes->post('get-course-fee', 'Course::getCourseFee');
    $routes->post('get-course-type', 'Course::getCourseType');
    $routes->post('get-course-by-center', 'Course::getCourseByCenter');
    $routes->post('get-courses-by-type', 'Course::getCoursesByType');
});

$routes->group('payment', function ($routes){
    $routes->get('list', 'Payment::list');
    $routes->get('pending-list', 'Payment::pendingList');
    $routes->get('(:num)', 'Payment::index/$1');
    $routes->get('invoice/(:num)', 'Payment::invoice/$1');
    $routes->post('add', 'Payment::add');
    $routes->post('get-payhistory', 'Payment::getPayHistory');
    $routes->post('import-csv', 'Payment::importCsv');
    $routes->post('get-list', 'Payment::getList');
    $routes->post('get-pending-list', 'Payment::getPendingList');
});

$routes->group('logs', function ($routes) {
    $routes->get('/', 'Editlog::index');
    $routes->post('student-edit', 'Editlog::getStudentEditLogs');
    $routes->post('payment-log', 'Editlog::getPaymentLogs');
    $routes->post('expense-log', 'Editlog::getExpenseLogs');
});

$routes->group('bin', function ($routes) {
    $routes->get('/', 'RecycleBin::index');
    $routes->post('get-deleted-students', 'RecycleBin::getDeletedStudents');
    $routes->post('get-deleted-inquiries', 'RecycleBin::getDeletedInquiries');
    $routes->post('delete-student', 'RecycleBin::deleteStudent');
    $routes->post('restore-student', 'RecycleBin::restoreStudent');
    $routes->post('delete-inquiry', 'RecycleBin::deleteInquiry');
    $routes->post('restore-inquiry', 'RecycleBin::restoreInquiry');
});

$routes->group('user', function ($routes) {
    //$routes->get('/', 'UserInfo::index');
    $routes->get('profile', 'UserInfo::profile');
    $routes->get('add', 'AddUserController::index');
    $routes->get('admin-list', 'UserInfo::AdminList');
    $routes->post('get-admin-list', 'UserInfo::getAdminList');
    $routes->get('edit/(:num)', 'UserInfo::edit/$1');
    $routes->post('update', 'UserInfo::updateInfo');
    $routes->get('change-password/(:num)', 'UserInfo::ChangePassword/$1');
    $routes->post('update-password', 'UserInfo::updatePassword');
    $routes->post('delete', 'UserInfo::deleteUser');
    $routes->post('change-status', 'UserInfo::changeStatus');
});

$routes->group('certificate', function ($routes){
    $routes->get('/', 'Certificate::index');
    $routes->get('add', 'Certificate::add');
    $routes->post('save', 'Certificate::save');
    $routes->post('list', 'Certificate::list');
    $routes->post('ex-student-list', 'Certificate::ex_student_list');
});

$routes->group('mytask', function ($routes){
    $routes->get('/', 'MyTask::index');
    $routes->post('list', 'MyTask::list');
    $routes->post('add', 'MyTask::add');
    $routes->post('change-sts', 'MyTask::changeStatus');
});

$routes->group('task', function ($routes){
    $routes->get('/', 'Task::index');
    $routes->post('list', 'Task::list');
    $routes->post('all-list', 'Task::all_list');
    $routes->post('approve-sts', 'Task::approveStatus');
});

$routes->group('attendance', function ($routes){
    $routes->get('/', 'Attendance::index');
    $routes->post('get-students', 'Attendance::getStudents');
    $routes->post('save', 'Attendance::save');
});
