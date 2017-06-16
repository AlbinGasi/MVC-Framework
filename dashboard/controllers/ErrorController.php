<?php

  class ErrorController extends Controller
  {
      public function __construct(){
          parent::__construct();
      }

      public function index(){
          $this->view->poruka = "The page doesn't exists";
          $this->view->render("error/index");
      }
  }

?>