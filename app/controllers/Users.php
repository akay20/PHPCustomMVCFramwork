<?php 

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
                    die('SUCCESS');
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

                // Make sure errors are empty
                if(empty($data['email_err']) && empty($data['password_err'])){
                    // Validate
                    die('SUCCESS');
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

    }

?>