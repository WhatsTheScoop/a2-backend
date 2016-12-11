<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Application
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/
	 * 	- or -
	 * 		http://example.com/welcome/index
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

function __construct()
	{
		parent::__construct();
		$this->load->model('supplies');
	}


	public function index()
	{
        $this->data['header'] = 'header';
		$this->data['pagebody'] = 'welcome_message';
        $this->render(); 
	}

}
