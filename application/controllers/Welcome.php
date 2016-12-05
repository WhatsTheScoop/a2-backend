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
        
        //amount spent on all inventory to date
        $this->data['inventorycost'] = "$".number_format(1000.00,2);
        //net amount received from sales
        $this->data['salesamount'] = "$".number_format(110.50,2);
        //cost of ingredients consumed to date
        $this->data['costofingredientsused'] = "$".number_format(210.21,2);
        
        $this->data['pagebody'] = 'welcome_message';
		
		//used for testing model values returned;
		//$this->data['pagebody'] = var_dump($this->supplies->add(1, 2));
		
        $this->render(); 
	}

}
