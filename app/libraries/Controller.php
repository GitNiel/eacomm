<?php 

    /*
        Base Controller
        Loads the models and views
    */

    class Controller{
        // Load model 
        public function model($model){
            // Require model file
            $nModal = ucfirst($model);
            require '../app/models/' . $nModal .'.php';

            // Instatiate model
            return new $nModal();
        }

        // Load view
        public function view($view, $data = []){
            // Check for the view file
            if(file_exists('../app/views/' . $view . '.php')){
                require_once '../app/views/' . $view . '.php';
            } else{
                // View does not exist
                die('View does not exist');
            }
        } 
    }