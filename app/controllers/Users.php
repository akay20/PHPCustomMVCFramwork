<?php 
// User controller
class Users extends Controller {

    public function __construct(){
        $this->userModel = $this->model('user');
    }

    public function register(){
        // Check for POST request
        if($_SERVER['REQUEST_METHOD'] == 'POST' ){

            // Process Form

            // Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init Data
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validate Email
            if(empty($data['email'])){
                $data['email_err'] = 'Please enter email';
            } else {
                // Check email already exists
                if ($this->userModel->finduserByEmail($data['email'])) {
                    $data['email_err'] = 'Email already exists';
                }
            }

            // Validate Name
            if(empty($data['name'])){
                $data['name_err'] = 'Please enter name';
            }

            // valdate Password
            if(empty($data['password'])){
                $data['password_err'] = 'Please enter password';
            } elseif(strlen($data['password']) < 6 ){
                $data['password_err'] = 'Passowrd must be at least 6 characters';
            }

            // validate Confirm password
            if(empty($data['confirm_password'])){
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if($data['password'] != $data['confirm_password']){
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            // Make sure errors are empty
            if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                // Validate
                
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                
                // Register User
                if($this->userModel->register($data)){
                    flash('register_success', 'You are now registered, You can Login!');
                    redirect('users/login');
                } else {
                    die('Something went Wrong');
                }
            } else {
                // Load view
                $this->view('users/register', $data);
            }

            
        } else {
            // Init data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Load view
            $this->view('users/register', $data);
        }
    }

    public function login(){
        // Check for post request
        if($_SERVER['REQUEST_METHOD'] == 'POST' ){

            // Load Form

            // Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init Data
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            // Validate Email
            if(empty($data['email'])){
                $data['email_err'] = 'Please enter email';
            }

            // valdate Password
            if(empty($data['password'])){
                $data['password_err'] = 'Please enter password';
            }

            // Check for user/email
            if($this->userModel->findUserByEmail($data['email'])){
                // User found
            } else {
                // user not found
                $data['email_err'] = 'No User found';
            }

            if(empty($data['email_err']) && empty($data['password_err'])){
                // validate
                // Check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if($loggedInUser){
                    // cretate session
                    $this->userModel->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Incorrect Password';
                    $this->view('users/login', $data);
                }

            } else {
                // Load view with error
                $this->view('users/login', $data);
            }

            // Make sure errors are empty
            if(empty($data['email_err']) && empty($data['password_err'])){
                // Validate
                
            } else {
                // Load view
                $this->view('users/login', $data);
            }

        } else {
            // Init data
            $data = [
                'email' => '',
                'password' => '',
                'password_err' => '',
                'email_err' => ''
            ];

            // Load view
            $this->view('users/login', $data);
        }
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('users/login');
    }

    public function isLoggedIn(){
        if(isset($_SESSION['user_id'])){
            return true;
        } else {
            return false;
        }
    }

}

?>