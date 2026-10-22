<?php
/**
 * Main Entry Point / Router System JosLearn.
 */
session_start();
date_default_timezone_set('Asia/Jakarta');

require_once __DIR__ . '/config/constants.php';

// Tampilkan error saat pengembangan saja
if (defined('DEV_MODE') && DEV_MODE) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/controllers/ReportController.php';
require_once __DIR__ . '/controllers/TeacherController.php';
require_once __DIR__ . '/controllers/AttendanceController.php';

$controller = $_GET['controller'] ?? 'auth';
$action     = $_GET['action'] ?? 'login';
$isPost     = $_SERVER['REQUEST_METHOD'] === 'POST';

// Routing berbasis controller dan action
switch ($controller) {
    case 'auth':
        $auth = new AuthController();
        switch ($action) {
            case 'new_password':
                $isPost ? $auth->saveNewPassword() : $auth->showNewPassword();
                break;
            case 'verify_otp':
                require __DIR__ . '/views/auth/verify_otp.php';
                break;
            case 'login':
            default:
                require __DIR__ . '/views/auth/login.php';
                break;
        }
        break;

    case 'admin':
        $admin = new AdminController();
        switch ($action) {
            case 'dashboard':
                $admin->dashboard();
                break;
            case 'student_master':
                $admin->studentMaster();
                break;
            case 'teacher_master':
                $admin->teacherMaster();
                break;
            case 'teacher_assignment':
                $admin->teacherAssignment();
                break;
            case 'leave_requests':
                $admin->leaveRequests();
                break;
            case 'attendance_recap':
                $admin->attendanceRecap();
                break;
            default:
                $admin->dashboard();
                break;
        }
        break;

    case 'report':
        $report = new ReportController();
        switch ($action) {
            case 'index':
                $report->index();
                break;
            case 'verification':
                $report->verification();
                break;
            case 'edit':
                $report->edit();
                break;
            default:
                $report->index();
                break;
        }
        break;

    case 'teacher':
        $teacher = new TeacherController();
        switch ($action) {
            case 'dashboard':
                $teacher->dashboard();
                break;
            case 'data_siswa':
                $teacher->dataSiswa();
                break;
            default:
                $teacher->dashboard();
                break;
        }
        break;

    case 'attendance':
        $attendance = new AttendanceController();
        switch ($action) {
            case 'permission':
                $attendance->permission();
                break;
            case 'recap':
                $attendance->recap();
                break;
            default:
                $attendance->recap();
                break;
        }
        break;

    default:
        http_response_code(404);
        echo 'Halaman tidak ditemukan.';
        break;
}
