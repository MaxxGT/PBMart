<?php
// Author: VOONG TZE HOWE
// Date Writen: 26-10-2014
// Description : LinkedList
// Last Modification: 27-10-2014

include('session_config.php');

class ListNode
{
    public $data;
    public $next;
    function __construct($data)
    {
        $this->data = $data;
        $this->next = NULL;
    }
    function readNode()
    {
        return $this->data;
    }
}
class LinkList
{
    private $firstNode;
    private $lastNode;
    private $count;

    function __construct()
    {
        $this->firstNode = NULL;
        $this->lastNode = NULL;
        $this->count = 0;
    }

    //insertion at the start of linklist
    public function insertFirst($data)
    {
        $link = new ListNode($data);
        $link->next = $this->firstNode;
        $this->firstNode = &$link;

        /* If this is the first node inserted in the list
           then set the lastNode pointer to it.
        */
        if($this->lastNode == NULL)
            $this->lastNode = &$link;
            $this->count++;
    }


    //displaying all nodes of linklist
    public function readList()
    {
        $listData = array();
        $current = $this->firstNode;
        while($current != NULL)
        {
            array_push($listData, $current->readNode());
            $current = $current->next;
        }
        //foreach($listData as $v){
        //    echo $v." ";
        //}
		
		$i='0';
		foreach($listData as $temp_var)
		{	
		//echo ('i:'.$i);
			echo "<br/>";
			echo $temp_var[0][0];
			echo "<br/>";
			echo $temp_var[0][1];
			echo "<br/>";
			
		}
		
    }
	
	//assign remaining product info into session
    public function assignSession_product()
    {
        $listData = array();
        $current = $this->firstNode;
        while($current != NULL)
        {
            array_push($listData, $current->readNode());
            $current = $current->next;
        }
        
		unset($_SESSION['order_qty']);
		unset($_SESSION['product_id']);
		unset($_SESSION['product_qty']);
		
		$i='0';
		foreach($listData as $temp_var)
		{
			$_SESSION['product_id'][$i] = $temp_var[0][0];
			$_SESSION['product_qty'][$i] = $temp_var[0][1];
			$i++;
		}
		$_SESSION['order_qty'] = $i;
		echo "<script language='JavaScript'>window.top.location ='shopping_cart.php?hyperlink=product';</script>";
    }
	
	public function assignSession_redeem()
    {
        $listData = array();
        $current = $this->firstNode;
        while($current != NULL)
        {
            array_push($listData, $current->readNode());
            $current = $current->next;
        }
        
		unset($_SESSION['redeem_order_qty']);
		unset($_SESSION['redeem_id']);
		unset($_SESSION['redeem_qty']);
		
		$i='0';
		foreach($listData as $temp_var)
		{
			$_SESSION['redeem_id'][$i] = $temp_var[0][0];
			$_SESSION['redeem_qty'][$i] = $temp_var[0][1];
			$i++;
		}
		$_SESSION['redeem_order_qty'] = $i;
		echo "<script language='JavaScript'>window.top.location ='shopping_cart.php?hyperlink=product';</script>";
    }
	
	public function countList()
	{
		$temp = '0';
		$listData = array();
        $current = $this->firstNode;
        while($current != NULL)
        {
            array_push($listData, $current->readNode());
            $current = $current->next;
        }
        foreach($listData as $v){
          $temp++;
        }
		
		return $temp;
	}

    //reversing all nodes of linklist
    public function reverseList()
    {
        if($this->firstNode != NULL)
        {
            if($this->firstNode->next != NULL)
            {
                $current = $this->firstNode;
                $new = NULL;

                while ($current != NULL)
                {
                    $temp = $current->next;
                    $current->next = $new;
                    $new = $current;
                    $current = $temp;
                }
                $this->firstNode = $new;
            }
        }
    }

    //deleting a node from linklist $key is the value you want to delete
    public function deleteNode($key)
    {
		$x = '0';
        $current = $this->firstNode;
        $previous = $this->firstNode;

        while($x != $key)
        {
            if($current->next == NULL)
                return NULL;
            else
            {
                $previous = $current;
                $current = $current->next;
            }
			$x++;
        }

        if($current == $this->firstNode)
         {
              if($this->count == 1)
               {
                  $this->lastNode = $this->firstNode;
               }
               $this->firstNode = $this->firstNode->next;
        }
        else
        {
            if($this->lastNode == $current)
            {
                 $this->lastNode = $previous;
             }
            $previous->next = $current->next;
        }
        $this->count--;  
    }

    //empty linklist
    public function emptyList()
    {
        $this->firstNode == NULL;
    }

    //insertion at index
    public function insert($NewItem,$key){
        if($key == 0){
        $this->insertFirst($NewItem);
    }
    else{
        $link = new ListNode($NewItem);
        $current = $this->firstNode;
        $previous = $this->firstNode;

        for($i=0;$i<$key;$i++)
        {       
                $previous = $current;
                $current = $current->next;
        }

           $previous->next = $link;
           $link->next = $current; 
           $this->count++;
    }

    }   
}
?>