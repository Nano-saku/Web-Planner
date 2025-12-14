<?php
if (($_SESSION['role'] ?? -1) !== 1) {   // 0 1 2 depending on file
    header('Location: /login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - DSSC</title>
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

        .btn-warning {
            background: linear-gradient(135deg, var(--warning), #e67e22);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger), #c0392b);
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

        /* Insights Cards */
        .insights-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .insight-card {
            background: var(--white);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .insight-card h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: var(--text-dark);
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: var(--border-color);
            border-radius: 4px;
            overflow: hidden;
            margin: 10px 0;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(135deg, var(--light-blue), var(--primary-blue));
            transition: width 0.3s ease;
        }

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

            .insights-grid {
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
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="https://www.dssc.edu.ph/images/DSSC.png" alt="DSSC Logo" class="sidebar-logo">
            <div class="sidebar-title">
                <h2>Teacher Portal</h2>
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
                <a class="nav-link" onclick="showPage('students')">
                    <i class="fas fa-users"></i>
                    <span>Manage Students</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="showPage('projects')">
                    <i class="fas fa-tasks"></i>
                    <span>Project Monitoring</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="showPage('grades')">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Grade Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="showPage('insights')">
                    <i class="fas fa-chart-line"></i>
                    <span>Insights & Analytics</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="showPage('announcements')">
                    <i class="fas fa-bullhorn"></i>
                    <span>Announcements</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="user-info">
                <div class="user-avatar">TC</div>
                <div class="user-details">
                    <h3>Mr. John Smith</h3>
                    <p>Computer Science Teacher</p>
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
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Total Students</h3>
                        <p id="totalStudents">0</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Active Projects</h3>
                        <p id="activeProjects">0</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Pending Reviews</h3>
                        <p id="pendingReviews">0</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon red">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Overdue Projects</h3>
                        <p id="overdueProjects">0</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Average Grade</h3>
                        <p id="averageGrade">0%</p>
                    </div>
                </div>
            </div>

            <div class="section-header">
                <h2>Recent Activity</h2>
            </div>

            <div class="content-container">
                <div id="recentActivity">
                    <div class="empty-state">
                        <i class="fas fa-chart-line"></i>
                        <h3>No recent activity</h3>
                        <p>Student activities will appear here</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Management Page -->
        <div class="page-content" id="students">
            <div class="section-header">
                <h2>Manage Students</h2>
                <button class="btn btn-primary" onclick="openAddStudent()">
                    <i class="fas fa-plus"></i> Add Student
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentsList">
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px;">
                                <div class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <h3>No students found</h3>
                                    <p>Add students to get started</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Project Monitoring Page -->
        <div class="page-content" id="projects">
            <div class="section-header">
                <h2>Project Monitoring</h2>
                <button class="btn btn-primary" onclick="refreshProjects()">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>

            <div class="content-container">
                <div id="projectMonitoring">
                    <div class="empty-state">
                        <i class="fas fa-tasks"></i>
                        <h3>No projects to monitor</h3>
                        <p>Student projects will appear here</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grade Management Page -->
        <div class="page-content" id="grades">
            <div class="section-header">
                <h2>Grade Management</h2>
                <button class="btn btn-success" onclick="exportGrades()">
                    <i class="fas fa-download"></i> Export Grades
                </button>
            </div>

            <div class="content-container">
                <div id="gradeManagement">
                    <div class="empty-state">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>No grades to manage</h3>
                        <p>Student grades will appear here</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Insights Page -->
        <div class="page-content" id="insights">
            <div class="section-header">
                <h2>Insights & Analytics</h2>
                <button class="btn btn-primary" onclick="generateReport()">
                    <i class="fas fa-chart-bar"></i> Generate Report
                </button>
            </div>

            <div class="insights-grid">
                <div class="insight-card">
                    <h3>Class Performance</h3>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 75%"></div>
                    </div>
                    <p>Average Score: 75%</p>
                </div>
                <div class="insight-card">
                    <h3>Project Completion Rate</h3>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 82%"></div>
                    </div>
                    <p>82% of projects completed on time</p>
                </div>
                <div class="insight-card">
                    <h3>Student Engagement</h3>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 68%"></div>
                    </div>
                    <p>68% active participation</p>
                </div>
                <div class="insight-card">
                    <h3>Grade Distribution</h3>
                    <div style="margin-top: 15px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span>A (90-100%)</span>
                            <span>25%</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span>B (80-89%)</span>
                            <span>35%</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span>C (70-79%)</span>
                            <span>30%</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>D (60-69%)</span>
                            <span>10%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Announcements Page -->
        <div class="page-content" id="announcements">
            <div class="section-header">
                <h2>Announcements</h2>
                <button class="btn btn-primary" onclick="openAddAnnouncement()">
                    <i class="fas fa-plus"></i> New Announcement
                </button>
            </div>

            <div class="content-container">
                <div id="announcementsList">
                    <div class="empty-state">
                        <i class="fas fa-bullhorn"></i>
                        <h3>No announcements</h3>
                        <p>Create your first announcement</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Settings Modal -->
    <div class="modal" id="settingsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Settings</h2>
                <button class="close-btn" onclick="closeSettings()">&times;</button>
            </div>
            <div class="setting-item">
                <div>
                    <h3>Dark Mode</h3>
                    <p style="font-size: 14px; color: var(--text-light);">Toggle dark theme</p>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="darkModeToggle" onchange="toggleDarkMode()">
                    <span class="slider"></span>
                </label>
            </div>
            <div class="setting-item">
                <div>
                    <h3>Email Notifications</h3>
                    <p style="font-size: 14px; color: var(--text-light);">Receive email updates</p>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </div>

    <!-- Add Student Modal -->
    <div class="modal" id="addStudentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Student</h2>
                <button class="close-btn" onclick="closeAddStudent()">&times;</button>
            </div>
            <form id="studentForm" onsubmit="addStudent(event)">
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
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-plus"></i> Add Student
                </button>
            </form>
        </div>
    </div>

    <!-- Add Announcement Modal -->
    <div class="modal" id="addAnnouncementModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create Announcement</h2>
                <button class="close-btn" onclick="closeAddAnnouncement()">&times;</button>
            </div>
            <form id="announcementForm" onsubmit="addAnnouncement(event)">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" id="announcementTitle" required>
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea class="form-control" id="announcementMessage" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label>Target Audience</label>
                    <select class="form-control" id="announcementTarget" required>
                        <option value="all">All Students</option>
                        <option value="bsit">BSIT Students</option>
                        <option value="bscs">BSCS Students</option>
                        <option value="bsis">BSIS Students</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-paper-plane"></i> Post Announcement
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
        let students = [
            {
                id: '2021-001',
                name: 'Capapas Justine Renz, L',
                email: 'justine.capapas@dssc.edu.ph',
                course: 'BSCS',
                status: 'active'
            },
            {
                id: '2021-002',
                name: 'Delos Santos Maria, A',
                email: 'maria.delossantos@dssc.edu.ph',
                course: 'BSIT',
                status: 'active'
            },
            {
                id: '2021-003',
                name: 'Reyes John, B',
                email: 'john.reyes@dssc.edu.ph',
                course: 'BSIS',
                status: 'inactive'
            }
        ];

        let announcements = [];
        let projects = [];

        // Initialize
        function init() {
            loadData();
            updateDashboard();
            displayStudents();
            displayProjects();
            displayAnnouncements();
            
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
            document.getElementById('totalStudents').textContent = students.length;
            document.getElementById('activeProjects').textContent = projects.filter(p => p.status === 'active').length;
            document.getElementById('pendingReviews').textContent = projects.filter(p => p.status === 'pending-review').length;
            document.getElementById('overdueProjects').textContent = projects.filter(p => p.status === 'overdue').length;
            document.getElementById('averageGrade').textContent = '75%'; // Sample data
        }

        // Student management functions
        function displayStudents() {
            const tbody = document.getElementById('studentsList');
            
            if (students.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px;">
                            <div class="empty-state">
                                <i class="fas fa-users"></i>
                                <h3>No students found</h3>
                                <p>Add students to get started</p>
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
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-sm btn-primary" onclick="editStudent('${student.id}')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteStudent('${student.id}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function addStudent(e) {
            e.preventDefault();
            
            const student = {
                id: document.getElementById('studentId').value,
                name: document.getElementById('studentName').value,
                email: document.getElementById('studentEmail').value,
                course: document.getElementById('studentCourse').value,
                status: 'active'
            };

            students.push(student);
            saveData();
            displayStudents();
            updateDashboard();
            closeAddStudent();
            document.getElementById('studentForm').reset();
        }

        function editStudent(id) {
            const student = students.find(s => s.id === id);
            if (student) {
                // Populate form with student data
                document.getElementById('studentId').value = student.id;
                document.getElementById('studentName').value = student.name;
                document.getElementById('studentEmail').value = student.email;
                document.getElementById('studentCourse').value = student.course;
                
                // Remove existing student and add as new
                students = students.filter(s => s.id !== id);
                openAddStudent();
            }
        }

        function deleteStudent(id) {
            if (confirm('Are you sure you want to delete this student?')) {
                students = students.filter(s => s.id !== id);
                saveData();
                displayStudents();
                updateDashboard();
            }
        }

        // Project monitoring functions
        function displayProjects() {
            const container = document.getElementById('projectMonitoring');
            
            // Sample project data
            projects = [
                {
                    id: 1,
                    title: 'Web Development Project',
                    student: 'Capapas Justine Renz, L',
                    status: 'pending-review',
                    deadline: '2024-01-15',
                    progress: 85
                },
                {
                    id: 2,
                    title: 'Database Design',
                    student: 'Delos Santos Maria, A',
                    status: 'active',
                    deadline: '2024-01-20',
                    progress: 60
                },
                {
                    id: 3,
                    title: 'Mobile App Development',
                    student: 'Reyes John, B',
                    status: 'overdue',
                    deadline: '2024-01-10',
                    progress: 45
                }
            ];

            if (projects.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-tasks"></i>
                        <h3>No projects to monitor</h3>
                        <p>Student projects will appear here</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = projects.map(project => {
                const statusClass = project.status === 'pending-review' ? 'warning' : 
                                  project.status === 'overdue' ? 'danger' : 'success';
                const statusText = project.status === 'pending-review' ? 'Pending Review' : 
                                 project.status === 'overdue' ? 'Overdue' : 'Active';

                return `
                    <div class="project-item" style="margin-bottom: 15px; padding: 20px; border: 2px solid var(--border-color); border-radius: 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                            <div>
                                <div style="font-size: 18px; font-weight: 600; margin-bottom: 5px;">${project.title}</div>
                                <div style="color: var(--text-light); font-size: 14px;">${project.student}</div>
                            </div>
                            <span class="status-badge status-${project.status}">
                                ${statusText}
                            </span>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <span>Progress</span>
                                <span>${project.progress}%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: ${project.progress}%"></div>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: var(--text-light);">
                                <i class="fas fa-calendar"></i> Due: ${new Date(project.deadline).toLocaleDateString()}
                            </span>
                            <div class="action-buttons">
                                <button class="btn btn-sm btn-primary" onclick="reviewProject(${project.id})">
                                    <i class="fas fa-eye"></i> Review
                                </button>
                                <button class="btn btn-sm btn-warning" onclick="sendFeedback(${project.id})">
                                    <i class="fas fa-comment"></i> Feedback
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function reviewProject(id) {
            alert('Opening project review for project ID: ' + id);
        }

        function sendFeedback(id) {
            alert('Sending feedback for project ID: ' + id);
        }

        // Grade management functions
        function exportGrades() {
            alert('Exporting grades to CSV file...');
        }

        // Insights functions
        function generateReport() {
            alert('Generating comprehensive report...');
        }

        // Announcement functions
        function displayAnnouncements() {
            const container = document.getElementById('announcementsList');
            
            if (announcements.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-bullhorn"></i>
                        <h3>No announcements</h3>
                        <p>Create your first announcement</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = announcements.map(announcement => `
                <div class="announcement-item" style="padding: 20px; border: 2px solid var(--border-color); border-radius: 12px; margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                        <h3 style="font-size: 18px; margin-bottom: 5px;">${announcement.title}</h3>
                        <span style="color: var(--text-light); font-size: 12px;">
                            ${new Date(announcement.createdAt).toLocaleDateString()}
                        </span>
                    </div>
                    <p style="margin-bottom: 10px;">${announcement.message}</p>
                    <span class="status-badge status-active">
                        <i class="fas fa-users"></i> ${announcement.target}
                    </span>
                </div>
            `).join('');
        }

        function addAnnouncement(e) {
            e.preventDefault();
            
            const announcement = {
                id: Date.now(),
                title: document.getElementById('announcementTitle').value,
                message: document.getElementById('announcementMessage').value,
                target: document.getElementById('announcementTarget').value,
                createdAt: new Date().toISOString()
            };

            announcements.push(announcement);
            saveData();
            displayAnnouncements();
            closeAddAnnouncement();
            document.getElementById('announcementForm').reset();
        }

        // Data persistence
        function saveData() {
            localStorage.setItem('teacherStudents', JSON.stringify(students));
            localStorage.setItem('teacherAnnouncements', JSON.stringify(announcements));
        }

        function loadData() {
            const savedStudents = localStorage.getItem('teacherStudents');
            const savedAnnouncements = localStorage.getItem('teacherAnnouncements');
            
            if (savedStudents) {
                students = JSON.parse(savedStudents);
            }
            
            if (savedAnnouncements) {
                announcements = JSON.parse(savedAnnouncements);
            }
        }

        // Modal functions
        function openSettings() {
            document.getElementById('settingsModal').classList.add('active');
        }

        function closeSettings() {
            document.getElementById('settingsModal').classList.remove('active');
        }

        function openAddStudent() {
            document.getElementById('addStudentModal').classList.add('active');
        }

        function closeAddStudent() {
            document.getElementById('addStudentModal').classList.remove('active');
        }

        function openAddAnnouncement() {
            document.getElementById('addAnnouncementModal').classList.add('active');
        }

        function closeAddAnnouncement() {
            document.getElementById('addAnnouncementModal').classList.remove('active');
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

        function refreshProjects() {
            displayProjects();
            alert('Projects refreshed!');
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