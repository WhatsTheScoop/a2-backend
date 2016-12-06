<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Supplies extends CI_Model{
    
    // var $data = array(
	// 	array('id' => '0',  'name' => 'Waffle Cone',    'price' => 50,  'type' => 'container',  'perBox' => 60, 'onHand' => 10),
	// 	array('id' => '1',  'name' => 'Regular Cone',   'price' => 25,  'type' => 'container',  'perBox' => 60, 'onHand' => 10),
    //     array('id' => '2',  'name' => 'Plastic Cup',    'price' => 15,  'type' => 'container',  'perBox' => 50, 'onHand' => 10),
    //     array('id' => '3',  'name' => 'Vanilla',        'price' => 20,  'type' => 'icecream',  'perBox' => 45, 'onHand' => 10),
    //     array('id' => '4',  'name' => 'Strawberry',     'price' => 20,  'type' => 'icecream',  'perBox' => 45, 'onHand' => 10),
    //     array('id' => '5',  'name' => 'Chocolate',      'price' => 20,  'type' => 'icecream',  'perBox' => 45, 'onHand' => 10),
    //     array('id' => '6',  'name' => 'Mint',           'price' => 25,  'type' => 'icecream',  'perBox' => 45, 'onHand' => 10),
    //     array('id' => '7',  'name' => 'Maple',          'price' => 25,  'type' => 'icecream',  'perBox' => 45, 'onHand' => 10),
    //     array('id' => '8',  'name' => 'Orange',         'price' => 25,  'type' => 'icecream',  'perBox' => 45, 'onHand' => 10),
    //     array('id' => '9',  'name' => 'Sprinkles',      'price' => 18,  'type' => 'garnish',  'perBox' => 120, 'onHand' => 10),
    //     array('id' => '10', 'name' => 'Walnuts',        'price' => 35,  'type' => 'garnish',  'perBox' => 85, 'onHand' => 0),
    //     array('id' => '11', 'name' => 'Chocolate Chips','price' => 13,  'type' => 'garnish',  'perBox' => 100, 'onHand' => 10),
	// );

	// Constructor
	public function __construct() {
		parent::__construct();
	}

	public function all(){
		$item = $this->db->query('Select * from supplies');
		return $item->result_array();
	}
	public function get($id){
		$item = $this->db->query('Select * from supplies where id = '. $id);
		return $item->result();
	}

	// get number of ingredient on hand
	public function getOnHand($id) {
		$item = $this->db->query('Select * from supplies where id = '. $id);
		return $item->row()->onHand;

	}

	//get box size of ingredient
	public function getPerBox($id) {
		$item = $this->db->query('Select * from supplies where id = '. $id);
		return $item->row()->perBox;
	}

	//receive an item
	public function add($id, $numOfBoxes){
		$item = $this->db->query('SELECT * FROM supplies WHERE id = '. $id);
		//check if id valid
		if($item.row() == null){
			return 1;
		}

		$itemName = $item->row()->name;
		$stock =  $item->row()->onHand;
		$boxSize = $item->row()->perBox;
		$val = $stock + ($numOfBoxes * $boxSize);
		$this->db->query('UPDATE supplies SET onHand = ' . $val . ' WHERE id = '. $id);

		//update log
		$data = 'RECEIVED:'.$numOfBoxes.' Boxe(s) of ' . $itemName .' on ' . date("Y/m/d") . "\n";
		if ( !write_file(APPPATH.'/logs/inventory.txt', $data, 'a')){
		     echo 'Unable to write the file';
		}
		return 0;
	}

	// this could be moded to take in a recipe?
	//use item from stocklist
	public function use($id, $numTaken){
		$item = $this->db->query('SELECT * FROM supplies WHERE id = '. $id);
		//check if id valid
		if($item.row() == null){
			return 1;
		}
		$stock =  $item->row()->onHand;
		$val = $stock - $numTaken;
		$this->db->query('UPDATE supplies SET onHand = ' . $val . ' WHERE id = '. $id);

		//Update Log
		$data = 'USED:'.$numTaken.' taken from ' . $itemName .' on ' . date("Y/m/d") . "\n";
		if ( !write_file(APPPATH.'/logs/inventory.txt', $data, 'a')){
		     echo 'Unable to write the file';
		}
		return 0;
	}
}