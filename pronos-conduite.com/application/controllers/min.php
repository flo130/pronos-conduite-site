<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Min extends CI_Controller
{
        public function index()
        {
            include(realpath (__DIR__.'/../libraries/minifier/index.php'));
        }
}

