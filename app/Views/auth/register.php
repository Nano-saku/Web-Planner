


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
            overflow-y: auto;
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

        /* Step indicator */
        .step-indicator {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .step {
            width: 40px;
            height: 4px;
            background: #e0e6ed;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .step.active {
            background: #3498db;
        }

        /* Form sections */
        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
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
        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
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

        .btn-secondary {
            background: #e0e6ed;
            color: #2c3e50;
        }

        .btn-secondary:hover {
            background: #d0d6dd;
        }

        .btn:active { transform: translateY(0); }

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
  margin-bottom: 20px;
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
                    <h2>Create Account</h2>
                    <p>Register to access your student planner</p>
                </div>
  <?php if(!empty($_SESSION['error'])): ?>
    <div class='alert-box'>
        <?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']);?>
    <?php endif; ?>
                <!-- Step Indicator -->
                <div class="step-indicator">
                    <div class="step active" id="step1"></div>
                    <div class="step" id="step2"></div>
                </div>
  
                <form id="registerForm" action="register/attempt" method="POST">
                    <!-- Step 1: Personal Information -->
                    <div class="form-section active" id="section1">
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Full Name</label>
                            <input type="text" id="fullname" name='fullname' required placeholder="Enter your full name">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-birthday-cake"></i> Age</label>
                            <input type="number" id="age" name='age'  required placeholder="Enter your age" min="1" max="100">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-map-marker-alt"></i> Address</label>
                            <input type="text" id="address" name='address' required placeholder="Enter your address">
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-primary" onclick="nextStep()">
                                Next <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Account Information -->
                    <div class="form-section" id="section2" >
                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" id="email" name = 'email' required placeholder="your.email@dssc.edu.ph">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-lock"></i> Password</label>
                            <div class="password-wrapper">
                                <input type="password" id="password" name = 'password' required minlength="6" placeholder="Create a password">
                                <i class="fas fa-eye-slash password-toggle" onclick="togglePassword('password', this)"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-lock"></i> Confirm Password</label>
                            <div class="password-wrapper">
                                <input type="password" id="confirmPassword" required minlength="6"  placeholder="Confirm your password">
                                <i class="fas fa-eye-slash password-toggle" onclick="togglePassword('confirmPassword', this)"></i>
                            </div>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary" onclick="prevStep()">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Register
                            </button>
                        </div>
                    </div>
                </form>

                <div class="link">
                    Already have an account? <a href="login">Sign in</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;

        function nextStep() {
            // Validate current step
            const section1 = document.getElementById('section1');
            const inputs = section1.querySelectorAll('input[required]');
            let valid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    valid = false;
                    input.focus();
                }
            });

            if (!valid) {
                alert('Please fill in all required fields');
                return;
            }

            currentStep = 2;
            updateSteps();
        }

        function prevStep() {
            currentStep = 1;
            updateSteps();
        }

        function updateSteps() {
            // Update sections
            document.querySelectorAll('.form-section').forEach((section, index) => {
                section.classList.remove('active');
                if (index + 1 === currentStep) {
                    section.classList.add('active');
                }
            });

            // Update step indicators
            document.querySelectorAll('.step').forEach((step, index) => {
                step.classList.remove('active');
                if (index + 1 <= currentStep) {
                    step.classList.add('active');
                }
            });
        }

        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }
//validate password
    const password = document.getElementById('password');
    const conf = document.getElementById('confirmPassword');
    const form = document.getElementById('registerForm');


     password.addEventListener('input', validate);
     conf.addEventListener('input', validate);

      form.addEventListener("submit", function(e){
         if(!validate){
               e.preventDefault();
               alert("Password do not match!");
         }
     });

    </script>



</body>
</html>
