

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - DSSC</title>
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

        /* Settings Modal */
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
            max-width: 500px;
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

        .modal-header h2 {
            font-size: 24px;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-light);
        }

        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
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

        .stat-info h3 {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 5px;
        }

        .stat-info p {
            font-size: 28px;
            font-weight: 700;
        }

        /* Projects Section */
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

        .projects-container {
            background: var(--white);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .project-item {
            padding: 20px;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .project-item:hover {
            border-color: var(--primary-blue);
            box-shadow: 0 4px 15px rgba(30, 77, 183, 0.1);
        }

        .project-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }

        .project-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .project-meta {
            display: flex;
            gap: 15px;
            color: var(--text-light);
            font-size: 14px;
            margin-bottom: 10px;
        }

        .project-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .difficulty-stars {
            color: #f39c12;
        }

        .deadline-badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .deadline-urgent { background: #fee; color: var(--danger); }
        .deadline-soon { background: #fff3cd; color: var(--warning); }
        .deadline-ok { background: #d4edda; color: var(--success); }

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

        .star-rating {
            display: flex;
            gap: 5px;
            font-size: 24px;
        }

        .star {
            cursor: pointer;
            color: #ddd;
            transition: all 0.2s ease;
        }

        .star:hover, .star.active {
            color: #f39c12;
        }

        /* Workflow Section */
        .workflow-container {
            background: var(--white);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }

        .workflow-canvas {
            min-width: 800px;
            padding: 20px;
        }

        .workflow-node {
            background: var(--white);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            position: relative;
            transition: all 0.3s ease;
        }

        .workflow-node:hover {
            border-color: var(--primary-blue);
            box-shadow: 0 4px 15px rgba(30, 77, 183, 0.15);
        }

        .workflow-node.high-priority {
            border-color: var(--danger);
            background: linear-gradient(to right, rgba(231, 76, 60, 0.05), transparent);
        }

        .workflow-node.medium-priority {
            border-color: var(--warning);
            background: linear-gradient(to right, rgba(243, 156, 18, 0.05), transparent);
        }

        .workflow-node.low-priority {
            border-color: var(--success);
            background: linear-gradient(to right, rgba(39, 174, 96, 0.05), transparent);
        }

        .node-connector {
            width: 2px;
            height: 30px;
            background: var(--border-color);
            margin: 0 auto;
        }

        .priority-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .priority-high { background: #fee; color: var(--danger); }
        .priority-medium { background: #fff3cd; color: var(--warning); }
        .priority-low { background: #d4edda; color: var(--success); }

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
                <h2>Student Portal</h2>
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
                <a class="nav-link" onclick="showPage('projects')">
                    <i class="fas fa-tasks"></i>
                    <span>My Projects</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="showPage('workflow')">
                    <i class="fas fa-project-diagram"></i>
                    <span>Workflow</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="showPage('calendar')">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Calendar</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="showPage('grades')">
                    <i class="fas fa-graduation-cap"></i>
                    <span>My Grades</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="showPage('progress')">
                    <i class="fas fa-chart-line"></i>
                    <span>Progress Tracker</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="user-info">
                <div class="user-avatar">JD</div>
                <div class="user-details">
                    <h3>Capapas Justine Renz, L</h3>
                    <p>Student</p>
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
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Total Projects</h3>
                        <p id="totalProjects">0</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Completed</h3>
                        <p id="completedProjects">0</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3>In Progress</h3>
                        <p id="inProgressProjects">0</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon red">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Urgent</h3>
                        <p id="urgentProjects">0</p>
                    </div>
                </div>
            </div>

            <div class="section-header">
                <h2>Recent Projects</h2>
                <button class="btn btn-primary" onclick="showPage('projects')">
                    <i class="fas fa-plus"></i> Add Project
                </button>
            </div>

            <div class="projects-container" id="recentProjects">
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h3>No projects yet</h3>
                    <p>Start by adding your first project!</p>
                </div>
            </div>
        </div>

        <!-- Projects Page -->
        <div class="page-content" id="projects">
            <div class="section-header">
                <h2>My Projects</h2>
                <button class="btn btn-primary" onclick="openAddProject()">
                    <i class="fas fa-plus"></i> Add New Project
                </button>
            </div>

            <div class="projects-container" id="allProjects">
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h3>No projects yet</h3>
                    <p>Click "Add New Project" to get started!</p>
                </div>
            </div>
        </div>

        <!-- Workflow Page -->
        <div class="page-content" id="workflow">
            <div class="section-header">
                <h2>Project Workflow</h2>
                <button class="btn btn-primary" onclick="generateWorkflow()">
                    <i class="fas fa-sync-alt"></i> Regenerate
                </button>
            </div>

            <div class="workflow-container" id="workflowCanvas">
                <div class="empty-state">
                    <i class="fas fa-project-diagram"></i>
                    <h3>No workflow generated</h3>
                    <p>Add projects to see your personalized workflow!</p>
                </div>
            </div>
        </div>

        <!-- Calendar Page -->
        <div class="page-content" id="calendar">
            <h2>Calendar View</h2>
            <div class="projects-container">
                <div class="empty-state">
                    <i class="fas fa-calendar-alt"></i>
                    <h3>Calendar Feature</h3>
                    <p>Coming soon - View all your deadlines in a calendar format</p>
                </div>
            </div>
        </div>

        <!-- Grades Page -->
        <div class="page-content" id="grades">
            <h2>My Grades</h2>
            <div class="projects-container">
                <div class="empty-state">
                    <i class="fas fa-graduation-cap"></i>
                    <h3>Grade Tracking</h3>
                    <p>Track your academic performance here</p>
                </div>
            </div>
        </div>

        <!-- Progress Page -->
        <div class="page-content" id="progress">
            <h2>Progress Tracker</h2>
            <div class="projects-container">
                <div class="empty-state">
                    <i class="fas fa-chart-line"></i>
                    <h3>Progress Analytics</h3>
                    <p>View your productivity statistics and trends</p>
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
                    <h3>Notifications</h3>
                    <p style="font-size: 14px; color: var(--text-light);">Deadline reminders</p>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </div>

    <!-- Add Project Modal -->
    <div class="modal" id="addProjectModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Project</h2>
                <button class="close-btn" onclick="closeAddProject()">&times;</button>
            </div>
            <form id="projectForm" onsubmit="addProject(event)">
                <div class="form-group">
                    <label>Project Name</label>
                    <input type="text" class="form-control" id="projectName" required>
                </div>
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" class="form-control" id="projectSubject" required>
                </div>
                <div class="form-group">
                    <label>Teacher</label>
                    <input type="text" class="form-control" id="projectTeacher" required>
                </div>
                <div class="form-group">
                    <label>Difficulty Rating</label>
                    <div class="star-rating" id="starRating">
                        <span class="star" data-rating="1">★</span>
                        <span class="star" data-rating="2">★</span>
                        <span class="star" data-rating="3">★</span>
                        <span class="star" data-rating="4">★</span>
                        <span class="star" data-rating="5">★</span>
                    </div>
                    <input type="hidden" id="projectDifficulty" required>
                </div>
                <div class="form-group">
                    <label>Deadline</label>
                    <input type="date" class="form-control" id="projectDeadline" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-plus"></i> Add Project
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
        <i class="fas fa-bars"></i>
    </button>

    <script>
        let projects = [];
        let selectedRating = 0;

        // Initialize
        function init() {
            loadProjects();
            updateDashboard();
            setupStarRating();
            
            // Check dark mode preference
            if (localStorage.getItem('darkMode') === 'true') {
                document.body.classList.add('dark-mode');
                document.getElementById('darkModeToggle').checked = true;
            }
        }

        // Star Rating
        function setupStarRating() {
            const stars = document.querySelectorAll('.star');
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    selectedRating = parseInt(this.dataset.rating);
                    document.getElementById('projectDifficulty').value = selectedRating;
                    updateStars();
                });
            });
        }

        function updateStars() {
            const stars = document.querySelectorAll('.star');
            stars.forEach((star, index) => {
                if (index < selectedRating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
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

            if (pageId === 'workflow') {
                generateWorkflow();
            }
        }

        // Projects
        function loadProjects() {
            const saved = localStorage.getItem('studentProjects');
            if (saved) {
                projects = JSON.parse(saved);
            }
        }

        function saveProjects() {
            localStorage.setItem('studentProjects', JSON.stringify(projects));
        }

        function addProject(e) {
            e.preventDefault();
            
            const project = {
                id: Date.now(),
                name: document.getElementById('projectName').value,
                subject: document.getElementById('projectSubject').value,
                teacher: document.getElementById('projectTeacher').value,
                difficulty: selectedRating,
                deadline: document.getElementById('projectDeadline').value,
                status: 'in-progress',
                createdAt: new Date().toISOString()
            };

            projects.push(project);
            saveProjects();
            updateDashboard();
            displayProjects();
            closeAddProject();
            document.getElementById('projectForm').reset();
            selectedRating = 0;
            updateStars();
        }

        function displayProjects() {
            const container = document.getElementById('allProjects');
            const recentContainer = document.getElementById('recentProjects');
            
            if (projects.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-folder-open"></i>
                        <h3>No projects yet</h3>
                        <p>Click "Add New Project" to get started!</p>
                    </div>
                `;
                recentContainer.innerHTML = container.innerHTML;
                return;
            }

            const projectsHTML = projects.map(project => {
                const urgency = getDeadlineUrgency(project.deadline);
                const stars = '★'.repeat(project.difficulty) + '☆'.repeat(5 - project.difficulty);
                
                return `
                    <div class="project-item">
                        <div class="project-header">
                            <div>
                                <div class="project-title">${project.name}</div>
                                <div class="project-meta">
                                    <span><i class="fas fa-book"></i> ${project.subject}</span>
                                    <span><i class="fas fa-user"></i> ${project.teacher}</span>
                                    <span class="difficulty-stars">${stars}</span>
                                </div>
                            </div>
                            <span class="deadline-badge deadline-${urgency}">
                                <i class="fas fa-calendar"></i> ${formatDate(project.deadline)}
                            </span>
                        </div>
                    </div>
                `;
            }).join('');

            container.innerHTML = projectsHTML;
            recentContainer.innerHTML = projects.slice(-3).reverse().map(project => {
                const urgency = getDeadlineUrgency(project.deadline);
                const stars = '★'.repeat(project.difficulty) + '☆'.repeat(5 - project.difficulty);
                
                return `
                    <div class="project-item">
                        <div class="project-header">
                            <div>
                                <div class="project-title">${project.name}</div>
                                <div class="project-meta">
                                    <span><i class="fas fa-book"></i> ${project.subject}</span>
                                    <span><i class="fas fa-user"></i> ${project.teacher}</span>
                                    <span class="difficulty-stars">${stars}</span>
                                </div>
                            </div>
                            <span class="deadline-badge deadline-${urgency}">
                                <i class="fas fa-calendar"></i> ${formatDate(project.deadline)}
                            </span>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function updateDashboard() {
            document.getElementById('totalProjects').textContent = projects.length;
            document.getElementById('completedProjects').textContent = 
                projects.filter(p => p.status === 'completed').length;
            document.getElementById('inProgressProjects').textContent = 
                projects.filter(p => p.status === 'in-progress').length;
            document.getElementById('urgentProjects').textContent = 
                projects.filter(p => getDeadlineUrgency(p.deadline) === 'urgent').length;
            
            displayProjects();
        }

        function getDeadlineUrgency(deadline) {
            const today = new Date();
            const deadlineDate = new Date(deadline);
            const diffDays = Math.ceil((deadlineDate - today) / (1000 * 60 * 60 * 24));
            
            if (diffDays < 3) return 'urgent';
            if (diffDays < 7) return 'soon';
            return 'ok';
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        }

        // Workflow Generation
        function generateWorkflow() {
            if (projects.length === 0) {
                document.getElementById('workflowCanvas').innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-project-diagram"></i>
                        <h3>No workflow generated</h3>
                        <p>Add projects to see your personalized workflow!</p>
                    </div>
                `;
                return;
            }

            // Sort by urgency and difficulty
            const sortedProjects = [...projects].sort((a, b) => {
                const urgencyA = getDeadlineUrgency(a.deadline);
                const urgencyB = getDeadlineUrgency(b.deadline);
                
                if (urgencyA === urgencyB) {
                    return b.difficulty - a.difficulty;
                }
                
                const urgencyOrder = { urgent: 0, soon: 1, ok: 2 };
                return urgencyOrder[urgencyA] - urgencyOrder[urgencyB];
            });

            const workflowHTML = sortedProjects.map((project, index) => {
                const urgency = getDeadlineUrgency(project.deadline);
                const priorityClass = urgency === 'urgent' ? 'high-priority' : 
                                    urgency === 'soon' ? 'medium-priority' : 'low-priority';
                const priorityBadgeClass = urgency === 'urgent' ? 'priority-high' : 
                                          urgency === 'soon' ? 'priority-medium' : 'priority-low';
                const priorityText = urgency === 'urgent' ? 'HIGH PRIORITY' : 
                                   urgency === 'soon' ? 'MEDIUM PRIORITY' : 'LOW PRIORITY';
                const stars = '★'.repeat(project.difficulty) + '☆'.repeat(5 - project.difficulty);

                return `
                    ${index > 0 ? '<div class="node-connector"></div>' : ''}
                    <div class="workflow-node ${priorityClass}">
                        <span class="priority-badge ${priorityBadgeClass}">${priorityText}</span>
                        <div class="project-title">${index + 1}. ${project.name}</div>
                        <div class="project-meta">
                            <span><i class="fas fa-book"></i> ${project.subject}</span>
                            <span><i class="fas fa-user"></i> ${project.teacher}</span>
                            <span class="difficulty-stars">${stars}</span>
                            <span><i class="fas fa-calendar"></i> Due: ${formatDate(project.deadline)}</span>
                        </div>
                    </div>
                `;
            }).join('');

            document.getElementById('workflowCanvas').innerHTML = `
                <div style="text-align: center; margin-bottom: 20px;">
                    <h3 style="color: var(--text-dark);">Recommended Work Order</h3>
                    <p style="color: var(--text-light); font-size: 14px;">Complete tasks in this order for optimal results</p>
                </div>
                ${workflowHTML}
            `;
        }

        // Modals
        function openSettings() {
            document.getElementById('settingsModal').classList.add('active');
        }

        function closeSettings() {
            document.getElementById('settingsModal').classList.remove('active');
        }

        function openAddProject() {
            document.getElementById('addProjectModal').classList.add('active');
        }

        function closeAddProject() {
            document.getElementById('addProjectModal').classList.remove('active');
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
                window.location.href = '/login';
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