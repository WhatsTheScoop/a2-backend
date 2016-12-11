<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Supplies extends CI_Model{
    
	// Constructor
	public function __construct() {
		parent::__construct();
	}

	//CREATE****************************
	public function create($name,$price,$type,$perBox,$onHand){
		
		$item = $this->db->query("INSERT INTO supplies (name,price,type,PerBox,OnHand) VALUES ('".$name."', ".$price.", '".$type."', ".$perBox.", ".$onHand.")");

		//update Log
		$data = 'CREATED: '.$name . date(" 	Y/m/d") . "\n";
		if ( !write_file(APPPATH.'/logs/inventory.txt', $data, 'a')){
		     echo 'Unable to write the file';
		}
		return 0;
	}
	//READ********************************
	//GET ALL
	public function all(){
		$item = $this->db->query('Select * from supplies');
		return $item->result_array();
	}
	//GET ITEM
	public function get($id){
		$item = $this->db->query('Select * from supplies where id = '. $id);
		return $item->result();
	}
	//GET ONHAND
	public function getOnHand($id) {
		$item = $this->db->query('Select * from supplies where id = '. $id);
		return $item->row()->onHand;
	}
	//GET BOX SIZE
	public function getPerBox($id) {
		$item = $this->db->query('Select * from supplies where id = '. $id);
		return $item->row()->perBox;
	}
	//UPDATE*********************************8
	//RECEIVE ITEM
	public function add($id, $numOfBoxes){
		$item = $this->db->query('Select * from supplies where id = '. $id);
		//check if id valid
		if($item->row() == null){
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
	//USE AN ITEM (REDUCE ONHAND)
	public function use($id, $numTaken){
		$item = $this->db->query('SELECT * FROM supplies WHERE id = '. $id);
		//check if id valid
		if($item->row() == null){
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
	//UPDATE price of item
	public function priceChange($id, $newPrice){
		//check if id valid
		$item = $this->db->query('SELECT * FROM supplies WHERE id = '. $id);
		if($item->row() == null){
			return 1;
		}

		$this->db->query('UPDATE supplies SET price = ' . $newPrice . ' WHERE id = '. $id);

		//Update Log
		$data = 'EDITED: '.$item->row()->name.' price changed to ' . $newPrice .' on ' . date("Y/m/d") . "\n";
		if ( !write_file(APPPATH.'/logs/inventory.txt', $data, 'a')){
		     echo 'Unable to write the file';
		}
		return 0;
	}

	//UPDATE number of items per box
	public function perBoxChange($id, $newAmount){
		
		//check if id valid
		$item = $this->db->query('SELECT * FROM supplies WHERE id = '. $id);
		if($item->row() == null){
			return 1;
		}
		
		$this->db->query('UPDATE supplies SET perBox = ' . $newAmount . ' WHERE id = '. $id);

		//Update Log
		$data = 'EDITED: '.$item->row()->name.' price changed to ' . $newPrice .' on ' . date("Y/m/d") . "\n";
		if ( !write_file(APPPATH.'/logs/inventory.txt', $data, 'a')){
		     echo 'Unable to write the file';
		}
		return 0;
	}

	//DELETE***************************
	public function delete($id){
		//check if id valid
		$item = $this->db->query('SELECT * FROM supplies WHERE id = '. $id);
		if($item->row() == null){
			return 1;
		}

		$this->db->query('DELETE from supplies WHERE id = '. $id);

		//Update Log
		$data = 'DELETED: '.$item->row()->name.' deleted from list on ' . date("Y/m/d") . "\n";
		if ( !write_file(APPPATH.'/logs/inventory.txt', $data, 'a')){
		     echo 'Unable to write the file';
		}
		return 0;
	}


}