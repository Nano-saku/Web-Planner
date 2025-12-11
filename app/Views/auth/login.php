
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DSSC Activity Planner</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        position: relative;
        overflow: hidden;
        padding: 40px 20px;
    }

    /* Background with overlay effects */
    body::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: url('https://www.dssc.edu.ph/images/485200014_570150689419116_3259872958220450291_n.jpg') center/cover no-repeat;
        filter: brightness(0.7);
        z-index: -2;
    }

    body::after {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: linear-gradient(135deg, rgba(0, 40, 80, 0.85) 0%, rgba(0, 20, 40, 0.7) 100%);
        z-index: -1;
    }

    .container {
        display: flex;
        justify-content: center;
        width: 100%;
        max-width: 1400px;
    }

    .auth-card {
        background: rgba(255, 255, 255, 0.98);
        padding: 50px 45px;
        border-radius: 20px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
        max-width: 450px;
        width: 100%;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        animation: slideIn 0.6s ease-out;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* Header: logo + title side by side */
    .header-container {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px; /* reduced spacing */
        flex-wrap: wrap;
    }

    .logo-container .logo {
        width: 100px;
        height: auto;
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
        transform: translateY(3px); /* nudge logo down */
    }

    .title-container {
        transform: translateY(-2px); /* nudge title up */
    }

    .title-container h1 {
        color: #1a3a5c;
        margin-bottom: 5px;
        font-size: 32px;
        font-weight: 700;
    }

    .title-container .subtitle {
        color: #5a6c7d;
        margin-bottom: 0;
        font-size: 15px;
    }

    /* Form styling */
    .form-group {
        margin-bottom: 15px; /* reduced spacing to pull fields closer */
    }

    label {
        display: block;
        margin-bottom: 6px; /* slightly smaller spacing */
        color: #2c3e50;
        font-weight: 500;
        font-size: 14px;
    }

    label i {
        margin-right: 8px;
        color: #3498db;
        width: 16px;
    }

    input, select {
        width: 100%;
        padding: 12px 14px; /* slightly smaller padding */
        border: 2px solid #e0e6ed;
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: white;
    }

    input:focus, select:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52,152,219,0.1);
    }

    /* Buttons */
    .btn {
        width: 100%;
        padding: 15px;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(52,152,219,0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(52,152,219,0.4);
    }

    .btn-primary:active { transform: translateY(0); }

    .btn i { margin-right: 8px; }

    /* Links */
    .link {
        text-align: center;
        margin-top: 20px; /* slightly closer to button */
        color: #5a6c7d;
        font-size: 14px;
    }

    .link a {
        color: #3498db;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .link a:hover { color: #2980b9; text-decoration: underline; }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .auth-card { padding: 35px 30px; }
        h1 { font-size: 26px; }
    }
</style>

</head>
<body>
    <div class="container">
        <div class="auth-card">
            <div class="header-container">
                <div class="logo-container">
                    <img src="https://www.dssc.edu.ph/images/DSSC.png" alt="DSSC Logo" class="logo">
                </div>
                <div class="title-container">
                    <h1>Welcome Back</h1>
                    <p class="subtitle">Sign in to your Activity Planner</p>
                </div>
            </div>

            <form action="<?= url('login/attempt') ?>" method="POST">
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" required placeholder="your.email@dssc.edu.ph">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" required placeholder="Enter your password">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-user-tag"></i> Role</label>
                    <select name="role" required>
                        <option value="">Select your role</option>
                        <option value="0">Student</option>
                        <option value="1">Teacher</option>
                        <option value="2">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>

            <div class="link">
                Don't have an account? <a href="register.php">Register here</a>
            </div>
        </div>
    </div>
</body>
</html>
