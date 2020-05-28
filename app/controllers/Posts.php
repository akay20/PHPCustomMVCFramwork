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

}

?>