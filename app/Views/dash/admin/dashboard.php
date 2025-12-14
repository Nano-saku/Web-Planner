<?php
if (($_SESSION['role'] ?? -1) !== 2) {   // 0 1 2 depending on file
    header('Location: /login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - DSSC</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary-blue: #1e4db7;
            --dark-blue: #0a3fa6;
            --light-blue: #3498db;
            --bg-light: #f5f7fa;
            --text-dark: #2c3e50;
            --text-light: #5a6c7d;
            --border-color: #e0e6ed;
            --white: #ffffff;
            --success: #27ae60;
            --warning: #f39c12;
            --danger: #e74c3c;
            --sidebar-width: 260px;
        }

        body.dark-mode {
            --bg-light: #1a1a2e;
            --white: #16213e;
            --text-dark: #eaeaea;
            --text-light: #b4b4b4;
            --border-color: #2d3748;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            transition: all 0.3s ease;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            padding: 30px 20px;
            color: white;
            overflow-y: auto;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: white;
            padding: 8px;
        }

        .sidebar-title h2 {
            font-size: 20px;
            font-weight: 700;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 8px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .nav-link i {
            font-size: 18px;
            width: 20px;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 30px;
        }

        /* Header */
        .header {
            background: var(--white);
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--light-blue), var(--primary-blue));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            font-weight: 700;
        }

        .user-details h3 {
            font-size: 18px;
            margin-bottom: 2px;
        }

        .user-details p {
            font-size: 14px;
            color: var(--text-light);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: none;
            background: var(--bg-light);
            color: var(--text-dark);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .icon-btn:hover {
            background: var(--primary-blue);
            color: white;
        }

        /* Page Content */
        .page-content {
            display: none;
        }

        .page-content.active {
            display: block;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Dashboard Cards */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--white);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .stat-icon.blue { background: linear-gradient(135deg, #3498db, #2980b9); }
        .stat-icon.green { background: linear-gradient(135deg, #27ae60, #229954); }
        .stat-icon.orange { background: linear-gradient(135deg, #f39c12, #e67e22); }
        .stat-icon.red { background: linear-gradient(135deg, #e74c3c, #c0392b); }
        .stat-icon.purple { background: linear-gradient(135deg, #9b59b6, #8e44ad); }
        .stat-icon.teal { background: linear-gradient(135deg, #1abc9c, #16a085); }

        .stat-info h3 {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 5px;
        }

        .stat-info p {
            font-size: 28px;
            font-weight: 700;
        }

        /* Content Sections */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h2 {
            font-size: 24px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--light-blue), var(--primary-blue));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success), #229954);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger), #c0392b);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning), #e67e22);
            color: white;
        }

        .content-container {
            background: var(--white);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .table th {
            background: var(--bg-light);
            font-weight: 600;
            color: var(--text-dark);
        }

        .table tr:hover {
            background: rgba(30, 77, 183, 0.05);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-active { background: #d4edda; color: var(--success); }
        .status-inactive { background: #fee; color: var(--danger); }
        .status-pending { background: #fff3cd; color: var(--warning); }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 13px;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            font-size: 15px;
            background: var(--bg-light);
            color: var(--text-dark);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(30, 77, 183, 0.1);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: var(--white);
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border-color);
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-light);
        }

        /* Analytics Dashboard */
        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-container {
            background: var(--white);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            min-height: 300px;
        }

        .chart-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 200px;
            background: var(--bg-light);
            border-radius: 10px;
            color: var(--text-light);
            font-size: 18px;
        }

        .activity-log {
            background: var(--white);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: white;
        }

        .activity-icon.add { background: var(--success); }
        .activity-icon.delete { background: var(--danger); }
        .activity-icon.update { background: var(--warning); }
        .activity-icon.login { background: var(--light-blue); }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: block;
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: 60px;
                height: 60px;
                border-radius: 50%;
                background: var(--primary-blue);
                color: white;
                border: none;
                font-size: 24px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
                z-index: 99;
                cursor: pointer;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .analytics-grid {
                grid-template-columns: 1fr;
            }
        }

        .mobile-menu-btn {
            display: none;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-light);
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .toggle-switch {
            position: relative;
            width: 50px;
            height: 26px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--primary-blue);
        }

        input:checked + .slider:before {
            transform: translateX(24px);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="https://www.dssc.edu.ph/images/DSSC.png" alt="DSSC Logo" class="sidebar-logo">
            <div class="sidebar-title">
                <h2>Admin Portal</h2>
            </div>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a class="nav-link active" onclick="showPage('dashboard')">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="showPage('teachers')">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Teacher Accounts</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="showPage('students')">
                    <i class="fas fa-user-graduate"></i>
                    <span>Student Accounts</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="showPage('analytics')">
                    <i class="fas fa-chart-pie"></i>
                    <span>System Analytics</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="showPage('logs')">
                    <i class="fas fa-history"></i>
                    <span>Activity Logs</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="showPage('settings')">
                    <i class="fas fa-cog"></i>
                    <span>System Settings</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="user-info">
                <div class="user-avatar">AD</div>
                <div class="user-details">
                    <h3>System Administrator</h3>
                    <p>Super Admin</p>
                </div>
            </div>
            <div class="header-actions">
                <button class="icon-btn" onclick="openSettings()">
                    <i class="fas fa-cog"></i>
                </button>
                <button class="icon-btn" onclick="logout()">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </div>
        </header>

        <!-- Dashboard Page -->
        <div class="page-content active" id="dashboard">
            <div class="dashboard-grid">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Total Teachers</h3>
                        <p id="totalTeachers">0</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Total Students</h3>
                        <p id="totalStudents">0</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Active Users</h3>
                        <p id="activeUsers">0</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon red">
                        <i class="fas fa-user-slash"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Inactive Accounts</h3>
                        <p id="inactiveAccounts">0</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Today's Logins</h3>
                        <p id="todayLogins">0</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon teal">
                        <i class="fas fa-server"></i>
                    </div>
                    <div class="stat-info">
                        <h3>System Health</h3>
                        <p id="systemHealth">100%</p>
                    </div>
                </div>
            </div>

            <div class="section-header">
                <h2>System Overview</h2>
            </div>

            <div class="content-container">
                <div id="systemOverview">
                    <div class="empty-state">
                        <i class="fas fa-chart-line"></i>
                        <h3>System Overview</h3>
                        <p>Real-time system statistics and performance metrics</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teacher Accounts Page -->
        <div class="page-content" id="teachers">
            <div class="section-header">
                <h2>Teacher Account Management</h2>
                <button class="btn btn-primary" onclick="openAddTeacher()">
                    <i class="fas fa-plus"></i> Create Teacher Account
                </button>
            </div>

            <div class="content-container">
                <table class="table" id="teachersTable">
                    <thead>
                        <tr>
                            <th>Teacher ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="teachersList">
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px;">
                                <div class="empty-state">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                    <h3>No teacher accounts</h3>
                                    <p>Create teacher accounts to get started</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Student Accounts Page -->
        <div class="page-content" id="students">
            <div class="section-header">
                <h2>Student Account Management</h2>
                <button class="btn btn-primary" onclick="openAddStudent()">
                    <i class="fas fa-plus"></i> Create Student Account
                </button>
            </div>

            <div class="content-container">
                <table class="table" id="studentsTable">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentsList">
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px;">
                                <div class="empty-state">
                                    <i class="fas fa-user-graduate"></i>
                                    <h3>No student accounts</h3>
                                    <p>Create student accounts to get started</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Analytics Page -->
        <div class="page-content" id="analytics">
            <div class="section-header">
                <h2>System Analytics</h2>
                <button class="btn btn-primary" onclick="generateReport()">
                    <i class="fas fa-download"></i> Export Report
                </button>
            </div>

            <div class="analytics-grid">
                <div class="chart-container">
                    <h3>User Registration Trends</h3>
                    <div class="chart-placeholder">
                        <i class="fas fa-chart-line"></i>
                        <p>Registration Chart</p>
                    </div>
                </div>
                <div class="chart-container">
                    <h3>Login Activity</h3>
                    <div class="chart-placeholder">
                        <i class="fas fa-chart-bar"></i>
                        <p>Login Activity Chart</p>
                    </div>
                </div>
                <div class="chart-container">
                    <h3>Account Distribution</h3>
                    <div class="chart-placeholder">
                        <i class="fas fa-chart-pie"></i>
                        <p>Account Types Distribution</p>
                    </div>
                </div>
                <div class="chart-container">
                    <h3>System Performance</h3>
                    <div class="chart-placeholder">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>Performance Metrics</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Logs Page -->
        <div class="page-content" id="logs">
            <div class="section-header">
                <h2>System Activity Logs</h2>
                <button class="btn btn-warning" onclick="clearLogs()">
                    <i class="fas fa-trash"></i> Clear Logs
                </button>
            </div>

            <div class="activity-log">
                <div id="activityLogs">
                    <div class="empty-state">
                        <i class="fas fa-history"></i>
                        <h3>No activity logs</h3>
                        <p>System activities will appear here</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Settings Page -->
        <div class="page-content" id="settings">
            <div class="section-header">
                <h2>System Settings</h2>
                <button class="btn btn-success" onclick="saveSettings()">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>

            <div class="content-container">
                <div class="setting-item" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid var(--border-color);">
                    <div>
                        <h3>Account Registration</h3>
                        <p style="font-size: 14px; color: var(--text-light);">Allow new account registrations</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" id="allowRegistration" checked>
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="setting-item" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid var(--border-color);">
                    <div>
                        <h3>Email Verification</h3>
                        <p style="font-size: 14px; color: var(--text-light);">Require email verification for new accounts</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" id="emailVerification" checked>
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="setting-item" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid var(--border-color);">
                    <div>
                        <h3>Auto Account Deletion</h3>
                        <p style="font-size: 14px; color: var(--text-light);">Automatically delete inactive accounts after 1 year</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" id="autoDelete">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="setting-item" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0;">
                    <div>
                        <h3>Maintenance Mode</h3>
                        <p style="font-size: 14px; color: var(--text-light);">Enable maintenance mode</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" id="maintenanceMode">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>
    </main>

    <!-- Settings Modal -->
    <div class="modal" id="settingsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Admin Settings</h2>
                <button class="close-btn" onclick="closeSettings()">&times;</button>
            </div>
            <div class="setting-item" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid var(--border-color);">
                <div>
                    <h3>Dark Mode</h3>
                    <p style="font-size: 14px; color: var(--text-light);">Toggle dark theme</p>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="darkModeToggle" onchange="toggleDarkMode()">
                    <span class="slider"></span>
                </label>
            </div>
            <div class="setting-item" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid var(--border-color);">
                <div>
                    <h3>Email Notifications</h3>
                    <p style="font-size: 14px; color: var(--text-light);">Receive system alerts</p>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                </label>
            </div>
            <div class="setting-item" style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3>Audit Logging</h3>
                    <p style="font-size: 14px; color: var(--text-light);">Log all admin actions</p>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </div>

    <!-- Create Teacher Modal -->
    <div class="modal" id="createTeacherModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create Teacher Account</h2>
                <button class="close-btn" onclick="closeCreateTeacher()">&times;</button>
            </div>
            <form id="teacherForm" onsubmit="createTeacher(event)">
                <div class="form-group">
                    <label>Teacher ID</label>
                    <input type="text" class="form-control" id="teacherId" required>
                </div>
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" class="form-control" id="teacherName" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" id="teacherEmail" required>
                </div>
                <div class="form-group">
                    <label>Department</label>
                    <select class="form-control" id="teacherDepartment" required>
                        <option value="">Select Department</option>
                        <option value="CS">Computer Science</option>
                        <option value="IT">Information Technology</option>
                        <option value="IS">Information Systems</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Initial Password</label>
                    <input type="password" class="form-control" id="teacherPassword" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-plus"></i> Create Account
                </button>
            </form>
        </div>
    </div>

    <!-- Create Student Modal -->
    <div class="modal" id="createStudentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create Student Account</h2>
                <button class="close-btn" onclick="closeCreateStudent()">&times;</button>
            </div>
            <form id="studentForm" onsubmit="createStudent(event)">
                <div class="form-group">
                    <label>Student ID</label>
                    <input type="text" class="form-control" id="studentId" required>
                </div>
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" class="form-control" id="studentName" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" id="studentEmail" required>
                </div>
                <div class="form-group">
                    <label>Course</label>
                    <select class="form-control" id="studentCourse" required>
                        <option value="">Select Course</option>
                        <option value="BSIT">BSIT</option>
                        <option value="BSCS">BSCS</option>
                        <option value="BSIS">BSIS</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Initial Password</label>
                    <input type="password" class="form-control" id="studentPassword" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-plus"></i> Create Account
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
        <i class="fas fa-bars"></i>
    </button>

    <script>
        // Sample data
        let teachers = [
            {
                id: 'TCH-001',
                name: 'Mr. John Smith',
                email: 'john.smith@dssc.edu.ph',
                department: 'CS',
                status: 'active',
                lastLogin: '2024-01-15 08:30 AM'
            },
            {
                id: 'TCH-002',
                name: 'Ms. Sarah Johnson',
                email: 'sarah.johnson@dssc.edu.ph',
                department: 'IT',
                status: 'active',
                lastLogin: '2024-01-14 02:15 PM'
            },
            {
                id: 'TCH-003',
                name: 'Mr. Michael Brown',
                email: 'michael.brown@dssc.edu.ph',
                department: 'IS',
                status: 'inactive',
                lastLogin: '2024-01-10 09:45 AM'
            }
        ];

        let students = [
            {
                id: '2021-001',
                name: 'Capapas Justine Renz, L',
                email: 'justine.capapas@dssc.edu.ph',
                course: 'BSCS',
                status: 'active',
                lastLogin: '2024-01-15 10:20 AM'
            },
            {
                id: '2021-002',
                name: 'Delos Santos Maria, A',
                email: 'maria.delossantos@dssc.edu.ph',
                course: 'BSIT',
                status: 'active',
                lastLogin: '2024-01-15 11:45 AM'
            },
            {
                id: '2021-003',
                name: 'Reyes John, B',
                email: 'john.reyes@dssc.edu.ph',
                course: 'BSIS',
                status: 'inactive',
                lastLogin: '2024-01-12 03:30 PM'
            }
        ];

        let activityLogs = [
            {
                id: 1,
                type: 'add',
                description: 'Created new teacher account: Mr. John Smith',
                timestamp: '2024-01-15 08:30 AM',
                user: 'System Admin'
            },
            {
                id: 2,
                type: 'delete',
                description: 'Deleted student account: 2020-099',
                timestamp: '2024-01-14 04:15 PM',
                user: 'System Admin'
            },
            {
                id: 3,
                type: 'update',
                description: 'Updated system settings: Email verification enabled',
                timestamp: '2024-01-14 02:00 PM',
                user: 'System Admin'
            },
            {
                id: 4,
                type: 'login',
                description: 'Admin login from IP: 192.168.1.100',
                timestamp: '2024-01-15 09:00 AM',
                user: 'System Admin'
            }
        ];

        // Initialize
        function init() {
            loadData();
            updateDashboard();
            displayTeachers();
            displayStudents();
            displayActivityLogs();
            
            // Check dark mode preference
            if (localStorage.getItem('darkMode') === 'true') {
                document.body.classList.add('dark-mode');
                document.getElementById('darkModeToggle').checked = true;
            }
        }

        // Navigation
        function showPage(pageId) {
            document.querySelectorAll('.page-content').forEach(page => {
                page.classList.remove('active');
            });
            document.getElementById(pageId).classList.add('active');

            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
            event.target.closest('.nav-link').classList.add('active');
        }

        // Dashboard functions
        function updateDashboard() {
            document.getElementById('totalTeachers').textContent = teachers.length;
            document.getElementById('totalStudents').textContent = students.length;
            document.getElementById('activeUsers').textContent = 
                teachers.filter(t => t.status === 'active').length + 
                students.filter(s => s.status === 'active').length;
            document.getElementById('inactiveAccounts').textContent = 
                teachers.filter(t => t.status === 'inactive').length + 
                students.filter(s => s.status === 'inactive').length;
            document.getElementById('todayLogins').textContent = Math.floor(Math.random() * 50) + 20;
            document.getElementById('systemHealth').textContent = '100%';
        }

        // Teacher management functions
        function displayTeachers() {
            const tbody = document.getElementById('teachersList');
            
            if (teachers.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px;">
                            <div class="empty-state">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <h3>No teacher accounts</h3>
                                <p>Create teacher accounts to get started</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = teachers.map(teacher => `
                <tr>
                    <td>${teacher.id}</td>
                    <td>${teacher.name}</td>
                    <td>${teacher.email}</td>
                    <td>${teacher.department}</td>
                    <td>
                        <span class="status-badge status-${teacher.status}">
                            ${teacher.status}
                        </span>
                    </td>
                    <td>${teacher.lastLogin}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-sm btn-warning" onclick="resetTeacherPassword('${teacher.id}')">
                                <i class="fas fa-key"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteTeacher('${teacher.id}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function createTeacher(e) {
            e.preventDefault();
            
            const teacher = {
                id: document.getElementById('teacherId').value,
                name: document.getElementById('teacherName').value,
                email: document.getElementById('teacherEmail').value,
                department: document.getElementById('teacherDepartment').value,
                status: 'active',
                lastLogin: 'Never'
            };

            teachers.push(teacher);
            saveData();
            displayTeachers();
            updateDashboard();
            closeCreateTeacher();
            document.getElementById('teacherForm').reset();
            
            // Log activity
            logActivity('add', `Created new teacher account: ${teacher.name}`);
            
            alert('Teacher account created successfully!');
        }

        function deleteTeacher(id) {
            if (confirm('Are you sure you want to delete this teacher account? This action cannot be undone.')) {
                const teacher = teachers.find(t => t.id === id);
                teachers = teachers.filter(t => t.id !== id);
                saveData();
                displayTeachers();
                updateDashboard();
                
                // Log activity
                logActivity('delete', `Deleted teacher account: ${teacher.name}`);
                
                alert('Teacher account deleted successfully!');
            }
        }

        function resetTeacherPassword(id) {
            if (confirm('Reset password for this teacher account?')) {
                const teacher = teachers.find(t => t.id === id);
                // Log activity
                logActivity('update', `Reset password for teacher: ${teacher.name}`);
                alert('Password reset instructions sent to teacher\'s email!');
            }
        }

        // Student management functions (read-only, no grades)
        function displayStudents() {
            const tbody = document.getElementById('studentsList');
            
            if (students.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px;">
                            <div class="empty-state">
                                <i class="fas fa-user-graduate"></i>
                                <h3>No student accounts</h3>
                                <p>Create student accounts to get started</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = students.map(student => `
                <tr>
                    <td>${student.id}</td>
                    <td>${student.name}</td>
                    <td>${student.email}</td>
                    <td>${student.course}</td>
                    <td>
                        <span class="status-badge status-${student.status}">
                            ${student.status}
                        </span>
                    </td>
                    <td>${student.lastLogin}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-sm btn-primary" onclick="viewStudentProfile('${student.id}')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" onclick="resetStudentPassword('${student.id}')">
                                <i class="fas fa-key"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteStudent('${student.id}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function createStudent(e) {
            e.preventDefault();
            
            const student = {
                id: document.getElementById('studentId').value,
                name: document.getElementById('studentName').value,
                email: document.getElementById('studentEmail').value,
                course: document.getElementById('studentCourse').value,
                status: 'active',
                lastLogin: 'Never'
            };

            students.push(student);
            saveData();
            displayStudents();
            updateDashboard();
            closeCreateStudent();
            document.getElementById('studentForm').reset();
            
            // Log activity
            logActivity('add', `Created new student account: ${student.name}`);
            
            alert('Student account created successfully!');
        }

        function deleteStudent(id) {
            if (confirm('Are you sure you want to delete this student account? This action cannot be undone.')) {
                const student = students.find(s => s.id === id);
                students = students.filter(s => s.id !== id);
                saveData();
                displayStudents();
                updateDashboard();
                
                // Log activity
                logActivity('delete', `Deleted student account: ${student.name}`);
                
                alert('Student account deleted successfully!');
            }
        }

        function resetStudentPassword(id) {
            if (confirm('Reset password for this student account?')) {
                const student = students.find(s => s.id === id);
                // Log activity
                logActivity('update', `Reset password for student: ${student.name}`);
                alert('Password reset instructions sent to student\'s email!');
            }
        }

        function viewStudentProfile(id) {
            const student = students.find(s => s.id === id);
            alert(`Student Profile:\n\nID: ${student.id}\nName: ${student.name}\nEmail: ${student.email}\nCourse: ${student.course}\nStatus: ${student.status}\nLast Login: ${student.lastLogin}\n\nNote: Grade information is restricted to teachers only.`);
        }

        // Activity logs functions
        function displayActivityLogs() {
            const container = document.getElementById('activityLogs');
            
            if (activityLogs.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-history"></i>
                        <h3>No activity logs</h3>
                        <p>System activities will appear here</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = activityLogs.map(log => `
                <div class="activity-item">
                    <div class="activity-icon ${log.type}">
                        <i class="fas fa-${getActivityIcon(log.type)}"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 600; margin-bottom: 2px;">${log.description}</div>
                        <div style="font-size: 12px; color: var(--text-light);">
                            ${log.timestamp} • ${log.user}
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function getActivityIcon(type) {
            const icons = {
                add: 'plus',
                delete: 'trash',
                update: 'edit',
                login: 'sign-in-alt'
            };
            return icons[type] || 'info-circle';
        }

        function logActivity(type, description) {
            const log = {
                id: Date.now(),
                type: type,
                description: description,
                timestamp: new Date().toLocaleString(),
                user: 'System Admin'
            };
            
            activityLogs.unshift(log);
            if (activityLogs.length > 50) activityLogs.pop(); // Keep only last 50 logs
            
            saveData();
            displayActivityLogs();
        }

        function clearLogs() {
            if (confirm('Are you sure you want to clear all activity logs?')) {
                activityLogs = [];
                saveData();
                displayActivityLogs();
                alert('Activity logs cleared successfully!');
            }
        }

        // Analytics functions
        function generateReport() {
            alert('Generating comprehensive system report...\n\nThis will include:\n- User registration trends\n- Login activity patterns\n- Account distribution\n- System performance metrics\n\nReport will be downloaded as PDF.');
        }

        // System settings functions
        function saveSettings() {
            const settings = {
                allowRegistration: document.getElementById('allowRegistration').checked,
                emailVerification: document.getElementById('emailVerification').checked,
                autoDelete: document.getElementById('autoDelete').checked,
                maintenanceMode: document.getElementById('maintenanceMode').checked
            };
            
            localStorage.setItem('adminSettings', JSON.stringify(settings));
            logActivity('update', 'Updated system settings');
            alert('Settings saved successfully!');
        }

        // Data persistence
        function saveData() {
            localStorage.setItem('adminTeachers', JSON.stringify(teachers));
            localStorage.setItem('adminStudents', JSON.stringify(students));
            localStorage.setItem('adminActivityLogs', JSON.stringify(activityLogs));
        }

        function loadData() {
            const savedTeachers = localStorage.getItem('adminTeachers');
            const savedStudents = localStorage.getItem('adminStudents');
            const savedActivityLogs = localStorage.getItem('adminActivityLogs');
            const savedSettings = localStorage.getItem('adminSettings');
            
            if (savedTeachers) {
                teachers = JSON.parse(savedTeachers);
            }
            
            if (savedStudents) {
                students = JSON.parse(savedStudents);
            }
            
            if (savedActivityLogs) {
                activityLogs = JSON.parse(savedActivityLogs);
            }
            
            if (savedSettings) {
                const settings = JSON.parse(savedSettings);
                document.getElementById('allowRegistration').checked = settings.allowRegistration;
                document.getElementById('emailVerification').checked = settings.emailVerification;
                document.getElementById('autoDelete').checked = settings.autoDelete;
                document.getElementById('maintenanceMode').checked = settings.maintenanceMode;
            }
        }

        // Modal functions
        function openSettings() {
            document.getElementById('settingsModal').classList.add('active');
        }

        function closeSettings() {
            document.getElementById('settingsModal').classList.remove('active');
        }

        function openAddTeacher() {
            document.getElementById('createTeacherModal').classList.add('active');
        }

        function closeCreateTeacher() {
            document.getElementById('createTeacherModal').classList.remove('active');
        }

        function openAddStudent() {
            document.getElementById('createStudentModal').classList.add('active');
        }

        function closeCreateStudent() {
            document.getElementById('createStudentModal').classList.remove('active');
        }

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
        }

        function toggleMobileMenu() {
            document.getElementById('sidebar').classList.toggle('mobile-open');
        }

        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                sessionStorage.clear();
                window.location.href = 'login.html';
            }
        }

        // Close modals on outside click
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
            }
        }

        // Initialize on load
        init();
    </script>
</body>
</html>