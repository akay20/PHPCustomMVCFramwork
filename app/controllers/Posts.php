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
        $this->userModel = $this->model('User');
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
        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->user_id);

        $data = [
            'id' => $id,
            'post' => $post,
            'user' => $user
        ];

        $this->view('posts/show', $data);
    }

    public function edit($id){

        if($_SERVER['REQUEST_METHOD'] == 'POST' ) {
            
            //Sanitize post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
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
                if($this->postModel->updatePosts($data)){
                    flash('post_message', 'Post Updated');
                    redirect('posts');
                } else {
                    die('Something Went wrong!');
                }

            } else {
                // Load view with errors
                $this->view('posts/edit', $data);
            }

        } else {
            // Get existing post from model
            $post = $this->postModel->getPostById($id);

            // Check for owner
            if($post->user_id != $_SESSION['user_id']){
                redirect('posts');
            }

            $data = [
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body
            ];

            $this->view('posts/edit', $data);
        }
    }

    public function delete($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST' ){
            // Get existing post from model
            $post = $this->postModel->getPostById($id);

            // Check for owner
            if($post->user_id != $_SESSION['user_id']){
                redirect('posts');
            }
            
            if($this->postModel->deletePost($id)){
                flash('post_message', 'Post Deleted');
                redirect('posts');
            } else {
                die('Something Went Wrong!');
            }
        } else {
            redirect('posts');
        }
    }

}

?>