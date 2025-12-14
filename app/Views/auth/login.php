
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
        align-items: center;
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
        border-radius: 20px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
        max-width: 900px;
        width: 100%;
        backdrop-filter: blur(10px);
        animation: slideIn 0.6s ease-out;
        display: flex;
        overflow: hidden;
        min-height: 600px;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Left side - Blue section with logo and title */
    .left-section {
        flex: 1;
        background: linear-gradient(135deg, #1e4db7 0%, #0a3fa6 50%, #072f7d 100%);
        padding: 60px 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    /* Animated gradient overlay */
    .left-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Decorative circles */
    .left-section::after {
        content: '';
        position: absolute;
        bottom: -100px;
        left: -100px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .logo-container {
        position: relative;
        z-index: 2;
        margin-bottom: 30px;
    }

    .logo-circle {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }

    .logo-circle img {
        width: 140px;
        height: 140px;
        object-fit: contain;
    }

    .title-container {
        position: relative;
        z-index: 2;
    }

    .title-container h1 {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 12px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        animation: slideFromLeft 1s ease-out;
    }

    @keyframes slideFromLeft {
        from { 
            opacity: 0; 
            transform: translateX(-50px); 
        }
        to { 
            opacity: 1; 
            transform: translateX(0); 
        }
    }

    .title-container .subtitle {
        font-size: 16px;
        opacity: 0.9;
        letter-spacing: 0.5px;
        animation: slideFromLeft 1s ease-out 0.2s both;
    }

    /* Right side - Form section */
    .right-section {
        flex: 1;
        padding: 60px 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: white;
    }

    .form-header {
        margin-bottom: 35px;
    }

    .form-header h2 {
        font-size: 28px;
        color: #1a3a5c;
        margin-bottom: 8px;
        font-weight: 700;
    }

    .form-header p {
        color: #5a6c7d;
        font-size: 14px;
    }

    /* Form styling */
    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
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
        padding: 14px 16px;
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

    /* Password field with toggle */
    .password-wrapper {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #888;
        font-size: 18px;
    }

    .password-toggle:hover {
        color: #3498db;
    }

    /* Buttons */
    .btn {
        width: 100%;
        padding: 16px;
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
        margin-top: 25px;
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
        .auth-card {
            flex-direction: column;
            min-height: auto;
        }
        
        .left-section {
            padding: 40px 30px;
        }
        
        .logo-circle {
            width: 140px;
            height: 140px;
        }
        
        .logo-circle img {
            width: 110px;
            height: 110px;
        }
        
        .title-container h1 {
            font-size: 28px;
        }
        
        .right-section {
            padding: 40px 30px;
        }
        
        .form-header h2 {
            font-size: 24px;
        }
    }
    .alert-box {
  background: #fee;
  border-left: 4px solid #c00;
  color: #900;
  padding: 10px 15px;
  margin-bottom: 10px;
  border-radius: 4px;
  font-size: 14px;
}
</style>

</head>
<body>
    <div class="container">
        <div class="auth-card">
            <!-- Left Blue Section -->
            <div class="left-section">
                <div class="logo-container">
                    <div class="logo-circle">
                        <img src="https://www.dssc.edu.ph/images/DSSC.png" alt="DSSC Logo">
                    </div>
                </div>
                <div class="title-container">
                    <h1>Welcome Back</h1>
                    <p class="subtitle">Student Web Planner</p>
                </div>
            </div>

            <!-- Right Form Section -->
            <div class="right-section">
                <div class="form-header">
                    <h2>Sign In</h2>
                    <p>Enter your credentials to access your account</p>
                </div>

                <form id="loginForm" action="login/attempt" method ="POST">
                    <div class="form-group">
                        <label><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" id="loginEmail" name= 'email' required placeholder="your.email@dssc.edu.ph">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-lock"></i> Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="loginPassword" name= 'password' required placeholder="Enter your password">
                            <i class="fas fa-eye-slash password-toggle" id="togglePassword"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                </form>
                <br>
<?php if(!empty($_SESSION['error'])): ?>
    <div class='alert-box'>
        <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']);?>  
    <?php endif; ?>
                <div class="link">
                    Don't have an account? <a href="register">Register here</a>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }
    </script>
    
</html>