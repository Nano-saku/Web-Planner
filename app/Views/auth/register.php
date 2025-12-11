<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - DSSC Activity Planner</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: url('https://www.dssc.edu.ph/images/485200014_570150689419116_3259872958220450291_n.jpg') center/cover no-repeat;
            filter: brightness(0.65);
            z-index: -2;
        }

        body::after {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(0, 40, 80, 0.85), rgba(0, 20, 40, 0.7));
            z-index: -1;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.97);
            padding: 35px 45px 60px 45px;
            border-radius: 30px;
            width: 600px;
            max-width: 100%;
            box-shadow: 0 22px 55px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(10px);
            animation: slideIn 0.5s ease-out;
            margin-bottom: 40px;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Header with logo + title side by side */
        .header-container {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 20px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .logo-container .logo {
            width: 85px;
             transform: translateX(50px);
        }

        .title-container h1 {
            margin-bottom: 5px;
            font-size: 28px;
            color: #1a3a5c;
             transform: translateX(50px);
        }

        .title-container .subtitle {
            margin-bottom: 0;
            color: #5a6c7d;
             transform: translateX(50px);
        }

        /* Form grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px 14px;
        }

        @media (max-width: 650px) {
            .grid { grid-template-columns: 1fr; }
            .header-container { flex-direction: column; align-items: center; text-align: center; }
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 6px;
            display: block;
        }

        .form-group label i { margin-right: 8px; color: #3498db; }

        input, select {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #e0e6ed;
            border-radius: 10px;
            font-size: 15px;
            transition: 0.3s;
            background: white;
        }

        input:focus, select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.15);
        }

        .btn {
            width: 100%;
            padding: 15px;
            border-radius: 10px;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            font-size: 17px;
            font-weight: 700;
            border: none;
            margin-top: 15px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52,152,219,0.35);
        }

        .link { text-align: center; margin-top: 15px; }

        .link a {
            color: #3498db;
            font-weight: 700;
            text-decoration: none;
        }

        .link a:hover { color: #2980b9; text-decoration: underline; }
    </style>
</head>

<body>
    <div class="auth-card">
        <div class="header-container">
            <div class="logo-container">
                <img src="https://www.dssc.edu.ph/images/DSSC.png" class="logo">
            </div>
            <div class="title-container">
                <h1>Student Registration</h1>
                <p class="subtitle">Create your DSSC Activity Planner account</p>
            </div>
        </div>

        <form id = "form" action="register/attempt" method="POST">
            <div class="grid">
                <div class="form-group">
                    <label><i class="fas fa-id-card"></i> Student ID</label>
                    <input type="text" id="studentId" name='studentId' required placeholder="ex: 20XX-12345">
                </div>

                <div class="form-group">
                    <label><i class="fas fa-user"></i> First Name</label>
                    <input type="text" id="firstName" name="firstName" required>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-user"></i> Middle Name</label>
                    <input type="text" id="middleName" name="middleName">
                </div>

                <div class="form-group">
                    <label><i class="fas fa-user"></i> Last Name</label>
                    <input type="text" id="lastName" name="lastName" required>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-graduation-cap"></i> Course</label>
                    <select id="course" name='course' required>
                        <option value="">Select course</option>
                        <option>BSIT</option>
                        <option>DIT</option>
                        <option>BSAB</option>
                        <option>BPA</option>
                    </select>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-layer-group"></i> Year Level</label>
                    <select id="year" name='year' required>
                        <option value="">Select year</option>
                        <option>1st Year</option>
                        <option>2nd Year</option>
                        <option>3rd Year</option>
                        <option>4th Year</option>
                    </select>
                </div>
            </div>
            <div class="form-group" style="grid-column: 1 / -1;">
                <label><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" required placeholder="your.email@example.com">
            </div>

            <div class="form-group">
               <label><i class="fas fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" required minlength="6">
            </div>

            <div class="form-group">
                <label><i class="fas fa-lock"></i> Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required minlength="6">
            </div>
            <button class="btn" type="submit">
                <i class="fas fa-user-plus"></i> Register
            </button>
        </form>

        <div class="link">
            Already have an account? <a href="login">Sign in</a>
        </div>
    </div>
    <script src = 'public\js\register.js'></script>
</body>
</html>
