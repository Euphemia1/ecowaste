<?php
/**
 * Authentication Controller for EcoWaste Application
 */

require_once 'BaseController.php';

class AuthController extends BaseController {

    /**
     * Display login page
     */
    public function login() {
        // Redirect if already logged in
        if ($this->user) {
            Helpers::redirect('/dashboard');
        }

        $data = [
            'title' => 'Login - EcoWaste',
            'layout' => 'auth'
        ];

        $this->render('auth/login', $data);
    }

    /**
     * Process login form
     */
    public function processLogin() {
        if (!$this->isPost()) {
            Helpers::redirect('/login');
        }

        $this->validateCSRF();

        $data = $this->getPostData([
            'email' => 'email',
            'password' => 'string',
            'remember_me' => 'string'
        ]);

        // Validate required fields
        $errors = Helpers::validateRequired($data, ['email', 'password']);

        if (!empty($errors)) {
            Helpers::setFlashMessage('error', 'Please fill in all required fields.');
            Helpers::redirect('/login');
        }

        // Validate email format
        if (!Security::validateEmail($data['email'])) {
            Helpers::setFlashMessage('error', 'Please enter a valid email address.');
            Helpers::redirect('/login');
        }

        // Rate limiting
        if (!Security::checkRateLimit('login_' . $_SERVER['REMOTE_ADDR'], 5, 300)) {
            Helpers::setFlashMessage('error', 'Too many login attempts. Please try again later.');
            Helpers::redirect('/login');
        }

        try {
            // Find user by email
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? AND status = 'active'");
            $stmt->execute([$data['email']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !Security::verifyPassword($data['password'], $user['password_hash'])) {
                Helpers::setFlashMessage('error', 'Invalid email or password.');
                Helpers::redirect('/login');
            }


            // Login successful - create session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['account_type'] = $user['account_type'];

            // Handle "remember me"
            if (!empty($data['remember_me'])) {
                $token = Security::generateToken();
                setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', false, true);
                
                // Store token in database (implement remember_tokens table if needed)
            }

            Helpers::setFlashMessage('success', 'Welcome back, ' . $user['first_name'] . '!');
            Helpers::redirect('/dashboard');

        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            Helpers::setFlashMessage('error', 'An error occurred. Please try again.');
            Helpers::redirect('/login');
        }
    }

    /**
     * Display registration page
     */
    public function register() {
        // Redirect if already logged in
        if ($this->user) {
            Helpers::redirect('/dashboard');
        }

        $data = [
            'title' => 'Register - EcoWaste',
            'account_types' => ACCOUNT_TYPES,
            'layout' => 'auth'
        ];

        $this->render('auth/register', $data);
    }

    /**
     * Process registration form
     */
    public function processRegister() {
        if (!$this->isPost()) {
            Helpers::redirect('/register');
        }

        $this->validateCSRF();

        $data = $this->getPostData([
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'email',
            'phone' => 'string',
            'password' => 'string',
            'confirm_password' => 'string',
            'account_type' => 'string',
            'company_name' => 'string',
            'terms_accepted' => 'string'
        ]);

        // Validate required fields
        $required = ['first_name', 'last_name', 'email', 'password', 'confirm_password', 'account_type'];
        if ($data['account_type'] === 'business') {
            $required[] = 'company_name';
        }

        $errors = Helpers::validateRequired($data, $required);

        // Additional validation
        if (!Security::validateEmail($data['email'])) {
            $errors['email'] = 'Please enter a valid email address';
        }

        if ($data['password'] !== $data['confirm_password']) {
            $errors['confirm_password'] = 'Passwords do not match';
        }

        $passwordErrors = Security::validatePassword($data['password']);
        if (!empty($passwordErrors)) {
            $errors['password'] = implode(', ', $passwordErrors);
        }

        if (!in_array($data['account_type'], array_keys(ACCOUNT_TYPES))) {
            $errors['account_type'] = 'Invalid account type';
        }

        if (!empty($data['phone']) && !Helpers::validatePhone($data['phone'])) {
            $errors['phone'] = 'Please enter a valid phone number';
        }

        if (empty($data['terms_accepted'])) {
            $errors['terms_accepted'] = 'You must accept the terms and conditions';
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                Helpers::setFlashMessage('error', $error);
            }
            Helpers::redirect('/register');
        }

        try {
            // Check if email already exists
            $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$data['email']]);
            if ($stmt->fetch()) {
                Helpers::setFlashMessage('error', 'An account with this email already exists.');
                Helpers::redirect('/register');
            }

            // Create user account
            $passwordHash = Security::hashPassword($data['password']);

            $stmt = $this->db->prepare("
                INSERT INTO users (
                    email, password_hash, first_name, last_name, phone, 
                    account_type, company_name, status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, 'active')
            ");

            $stmt->execute([
                $data['email'],
                $passwordHash,
                $data['first_name'],
                $data['last_name'],
                $data['phone'] ?: null,
                $data['account_type'],
                $data['company_name'] ?: null
            ]);

            $userId = $this->db->lastInsertId();

            if ($userId) {
                Helpers::setFlashMessage('success', 'Registration successful! Please login with your credentials.');
                Helpers::redirect('/login');
            } else {
                Helpers::setFlashMessage('error', 'Registration failed. Please try again.');
                Helpers::redirect('/register');
            }

        } catch (PDOException $e) {
            error_log("Registration error: " . $e->getMessage());
            Helpers::setFlashMessage('error', 'An error occurred while creating your account. Please try again.');
            Helpers::redirect('/register');
        }
    }

    /**
     * Logout user
     */
    public function logout() {
        // Clear remember me cookie if set
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/', '', false, true);
        }

        session_unset();
        session_destroy();
        
        Helpers::setFlashMessage('success', 'You have been logged out successfully.');
        Helpers::redirect('/');
    }

    /**
     * Display forgot password page
     */
    public function forgotPassword() {
        if ($this->user) {
            Helpers::redirect('/dashboard');
        }

        $data = [
            'title' => 'Forgot Password - EcoWaste',
            'layout' => 'auth'
        ];

        $this->render('auth/forgot-password', $data);
    }

    /**
     * Process forgot password form
     */
    public function processForgotPassword() {
        if (!$this->isPost()) {
            Helpers::redirect('/forgot-password');
        }

        $this->validateCSRF();

        $email = Security::sanitizeInput($_POST['email'] ?? '', 'email');

        if (empty($email) || !Security::validateEmail($email)) {
            Helpers::setFlashMessage('error', 'Please enter a valid email address.');
            Helpers::redirect('/forgot-password');
        }

        try {
            // Check if user exists
            $stmt = $this->db->prepare("SELECT id, first_name FROM users WHERE email = ? AND status = 'active'");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Generate reset token
                $resetToken = Security::generateToken();
                $resetExpires = date('Y-m-d H:i:s', time() + 3600); // 1 hour

                // Store reset token
                $stmt = $this->db->prepare("
                    UPDATE users 
                    SET password_reset_token = ?, password_reset_expires = ? 
                    WHERE id = ?
                ");
                $stmt->execute([$resetToken, $resetExpires, $user['id']]);

                // Send reset email
                $this->sendPasswordResetEmail($email, $resetToken, $user['first_name']);
            }

            // Always show success message (don't reveal if email exists)
            Helpers::setFlashMessage('success', 'If an account with that email exists, you will receive password reset instructions.');
            Helpers::redirect('/forgot-password');

        } catch (PDOException $e) {
            error_log("Forgot password error: " . $e->getMessage());
            Helpers::setFlashMessage('error', 'An error occurred. Please try again.');
            Helpers::redirect('/forgot-password');
        }
    }

    /**
     * Display reset password page
     */
    public function resetPassword() {
        $token = $_GET['token'] ?? '';
        
        if (empty($token)) {
            Helpers::setFlashMessage('error', 'Invalid reset link.');
            Helpers::redirect('/forgot-password');
        }

        // Verify token
        try {
            $stmt = $this->db->prepare("
                SELECT id, first_name, password_reset_expires 
                FROM users 
                WHERE password_reset_token = ? AND status = 'active'
            ");
            $stmt->execute([$token]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || strtotime($user['password_reset_expires']) < time()) {
                Helpers::setFlashMessage('error', 'Reset link has expired or is invalid.');
                Helpers::redirect('/forgot-password');
            }

            $data = [
                'title' => 'Reset Password - EcoWaste',
                'token' => $token,
                'layout' => 'auth'
            ];

            $this->render('auth/reset-password', $data);

        } catch (PDOException $e) {
            error_log("Reset password error: " . $e->getMessage());
            Helpers::redirect('/forgot-password');
        }
    }

    /**
     * Process reset password form
     */
    public function processResetPassword() {
        if (!$this->isPost()) {
            Helpers::redirect('/forgot-password');
        }

        $this->validateCSRF();

        $data = $this->getPostData([
            'token' => 'string',
            'password' => 'string',
            'confirm_password' => 'string'
        ]);

        // Validate
        $errors = Helpers::validateRequired($data, ['token', 'password', 'confirm_password']);

        if ($data['password'] !== $data['confirm_password']) {
            $errors['confirm_password'] = 'Passwords do not match';
        }

        $passwordErrors = Security::validatePassword($data['password']);
        if (!empty($passwordErrors)) {
            $errors['password'] = implode(', ', $passwordErrors);
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                Helpers::setFlashMessage('error', $error);
            }
            Helpers::redirect('/reset-password?token=' . $data['token']);
        }

        try {
            // Verify token and get user
            $stmt = $this->db->prepare("
                SELECT id FROM users 
                WHERE password_reset_token = ? 
                AND password_reset_expires > NOW() 
                AND status = 'active'
            ");
            $stmt->execute([$data['token']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                Helpers::setFlashMessage('error', 'Reset link has expired or is invalid.');
                Helpers::redirect('/forgot-password');
            }

            // Update password
            $passwordHash = Security::hashPassword($data['password']);
            $stmt = $this->db->prepare("
                UPDATE users 
                SET password_hash = ?, password_reset_token = NULL, password_reset_expires = NULL 
                WHERE id = ?
            ");
            $stmt->execute([$passwordHash, $user['id']]);

            Helpers::setFlashMessage('success', 'Your password has been reset successfully. You can now login.');
            Helpers::redirect('/login');

        } catch (PDOException $e) {
            error_log("Process reset password error: " . $e->getMessage());
            Helpers::setFlashMessage('error', 'An error occurred. Please try again.');
            Helpers::redirect('/forgot-password');
        }
    }

    /**
     * Send verification email
     */
    private function sendVerificationEmail($email, $token, $firstName) {
        // Implement email sending logic here
        // For now, just log the verification link
        $verificationUrl = APP_URL . "/verify-email?token=" . $token;
        error_log("Verification email for {$email}: {$verificationUrl}");
    }

    /**
     * Send password reset email
     */
    private function sendPasswordResetEmail($email, $token, $firstName) {
        // Implement email sending logic here
        // For now, just log the reset link
        $resetUrl = APP_URL . "/reset-password?token=" . $token;
        error_log("Password reset email for {$email}: {$resetUrl}");
    }
}
?>