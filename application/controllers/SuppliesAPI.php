<?php

require APPPATH . '/third_party/restful/libraries/Rest_controller.php';

class SuppliesAPI extends Rest_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('supplies');
	}
   
    //GET SPECIFIC INGREDIENTS
    //~/suppliesAPI/item/id/value
    //~/suppliesAPI/item
    function item_get(){
        $id = $this->get('id');
        if(!$id)
            $result = $this->supplies->all();
        else
             $result = $this->supplies->get($id);
        

        if ($result != null)
            $this->response($result, 200);
        else
            $this->response(array('error' => 'Ingredient not found!'), 404);      
    }
    //GET ONHAND OF AN INGREDIENT
    //~/suppliesAPI/onhand/id/value
    function onhand_get(){
        $id = $this->get('id');
        $result = $this->supplies->getOnHand($id);
        if ($result != null)
            $this->response($result, 200);
        else
            $this->response(array('error' => 'Ingredient not found!'), 404);      
    }
    //GET NUMBER OF PORTIONS PER BOX/BUCKET
    //~/suppliesAPI/perbox/id/value
    function perbox_get(){
        $id = $this->get('id');
        $result = $this->supplies->getPerBox($id);
        if ($result != null)
            $this->response($result, 200);
        else
            $this->response(array('error' => 'Ingredient not found!'), 404);      
    }
    //ADDS THE NUMBER OF BOXES RECEIVED/ UPDATES ONHAND
    //***NOTE NUMBER PASSED IS THE NUMBER OF BOXES!!!
    //~/suppliesAPI/receive/id/value/quantity/value
    function receive_put(){
        $id = $this->get('id');
        $number = $this->get('quantity');
        $result = $this->supplies->add($id, $number);
        if ($result == 0)
            $this->response(array('ok'), 200);
        else
            $this->response(array('error' => 'Ingredient not found!'), 404);      
    }
    // REMOVES THE NUMBER OF PORTIONS (USED IN MAKING A RECIPE)
    //***NOTE: NUMBER PASSED IS THE NUMBER OF PORTIONS USED DUE TO RECIPES REQUIRING DIFFERENT AMOUNTS
    //~/suppliesAPI/take/id/value/quantity/value
    function take_put(){
        $id = $this->get('id');
        $number = $this->get('quantity');
        $result = $this->supplies->take_put
        ($id, $number);
        if ($result == 0)
            $this->response(array('ok'), 200);
        else
            $this->response(array('error' => 'Ingredient not found!'), 404);      
    }
    //~/suppliesAPI/perBox/id/value/quantity/value
    function perBox_put(){
        $id = $this->get('id');
        $number = $this->get('quantity');
        //die(gettype($number));
        $result = $this->supplies->perBoxChange($id,$number);
        if ($result == 0)
            $this->response(array('ok'), 200);
        else
            $this->response(array('error' => 'Ingredient not found!'), 404);      
    }
    //~/suppliesAPI/price/id/value/quantity/value
    function price_put(){
        $id = $this->get('id');
        $number = $this->get('price');
        $result = $this->supplies->priceChange($id, $number);
        if ($result == 0)
            $this->response(array('ok'), 200);
        else
            $this->response(array('error' => 'Ingredient not found!'), 404);      
    }
    //~/suppliesAPI/new/name/value/price/value/type/value/amount/value
    function new_post(){
        $name = $this->get('name');
        $price = $this->get('price');
        $type = $this->get('type');
        $amount = $this->get('amount');
        $onHand = "0";
        $result = $this->supplies->create($name, $price, $type, $amount, $onHand);
        if ($result == 0)
            $this->response(array('ok'), 200);
        else
            $this->response(array('error' => 'Ingredient not found!'), 404);      
    }
    function delete_put(){
        $id = $this->get('id');
        $result = $this->supplies->delete($id);
         if ($result == 0)
            $this->response(array('ok'), 200);
        else
            $this->response(array('error' => 'Ingredient not found!'), 404);      
    }
}