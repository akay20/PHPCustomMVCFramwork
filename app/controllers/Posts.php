<?php 
// Posts controller

class Posts extends Controller {

    public function __construct(){

        // Check if user is logged in isLoggedIn from session helper
        if(!isLoggedIn()){
            //flash('post_login', 'login to view posts');
            redirect('users/login');
        }

        $this->postModel = $this->model('Post');
    }

    public function index() {
        // Get Post
        $posts = $this->postModel->getPosts();

        // Add Data for View
        $data = [
            'posts' => $posts
        ];
        // Include view and Pass data to view
        $this->view('posts/index', $data);
    }

    public function add(){

        if($_SERVER['REQUEST_METHOD'] == 'POST' ) {
            
            //Sanitize post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => ''
            ];

            //Validate Data
            if(empty($data['title'])){
                $data['title_err'] = 'Please Enter title';
            }
            if(empty($data['body'])){
                $data['body_err'] = 'Please enter body text';
            }

            if(empty($data['title_err']) && empty($data['body_err'])){
                // Validate
                if($this->postModel->addPosts($data)){
                    flash('post_message', 'Post Added');
                    redirect('posts');
                } else {
                    die('Something Went wrong!');
                }

            } else {
                // Load view with errors
                $this->view('posts/add', $data);
            }

        } else {
            $data = [
                'title' => '',
                'body' => ''
            ];

            $this->view('posts/add', $data);
        }
    }

    public function show($id){
        
    }

}

?>