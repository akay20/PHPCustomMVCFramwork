<?php
// URL helper

function redirect($page){
    header('location: ' . URLROOT . '/' . $page);
}

?>