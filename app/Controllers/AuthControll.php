<?php
require_once __DIR__ . '/../../core/firebase.php';

class Authenticator {

    public function showLogin() {
        require __DIR__ . '/../Views/auth/login.php';
    }

    public function showRegister() {
        require __DIR__ . '/../Views/auth/register.php';
    }

    public function showSdash(){
        require __DIR__ . '/../Views/dash/student/dashboard.php';
    }

    public function showTdash(){
        require __DIR__ . '/../Views/dash/teacher/dashboard.php';
    }

    public function showAdash(){
        require __DIR__ . '/../Views/dash/admin/dashboard.php';
    }

    public function store() {
        $firebase = new FirebaseService();
        $db = $firebase->db();
        $auth = $firebase->auth();
//  $course = $_POST['course'];
      //  $year = $_POST['year'];
        
     //   $studid = $_POST['studentId'];
     //   $cy = trim($course .' ' . $year);
        
        $age = $_POST['age'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $name = $_POST['fullname'];
        $password = $_POST['password'];
      
        try {
        $user = $auth->createUser([
            'email' => $email,
            'password' => $password,
        ]);
        $uid = $user->uid;
      

            // 'studentId' => $studid,
           // 'courseyear' => $cy,
         
        $db->getReference("users/$uid")->set([
            'name' => $name,
            'age' => $age,
            'address' => $address,
            'role' => 0,
        ]);

        $_SESSION['success'] = "Registration Complete.";
        header("Location: /login");
    
    }catch (Exception $e){
    $_SESSION['error'] = 'Registration failed: ' . $e ->getMessage();
      header("Location: /register");
        exit;
    }
    }

    public function authenticate() {
        $firebase = new FirebaseService();
        $auth = $firebase->auth();
        $db = $firebase->db();

        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            $user = $auth->signInWithEmailAndPassword($email, $password);
            $uid = $user->firebaseUserId();
            $snapshot = $db->getReference("users/{$uid}")->getValue();

            $_SESSION['uid'] = $uid;
            $_SESSION['role'] = (int) $snapshot['role'];

            if ($snapshot['role'] == 0) {
                header("Location: /student/dashboard");
                exit;
        }
        
            if ($snapshot['role'] == 1) {
                header("Location: /teacher/dashboard");
                exit;
        }
        
            if ($snapshot['role'] == 2) {
                header("Location: /admin/dashboard");
                exit;
        }

        } catch (Exception $e) {
            $_SESSION['error'] = 'Login Failed: ' . $e ->getMessage();
            header("Location: /login");
            exit;
        }
    }
}
?>
