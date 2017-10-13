<?php
//this is commercial class

class commercial{

public $_commercial_id;
public $_commercial_member_id;
public $_commercial_member_number;
public $_commercial_number;
public $_commercial_company;
public $_commercial_company_number;
public $_commercial_phone;
public $_commercial_address;
public $_commercial_city;
public $_commercial_postcode;
public $_commercial_state;
public $_commercial_country;
public $_commercial_person_incharge;
public $_commercial_person_ic;
public $_commercial_person_position;
public $_commercial_person_phone;

public $_commercial_form49;
public $_commercial_form24;
public $_commercial_form9;
public $_commercial_status;
public $_commercial_application_date;

function getCommercialId(){return 'COMMERCIAL'.str_pad($this->_commercial_id,4,0000, STR_PAD_LEFT);}

function setCommercial($commercial_id, $commercial_member_id, $commercial_member_number, $commercial_number, $commercial_company, $commercial_company_number, $commercial_phone , $commercial_address , $commercial_city, $commercial_postcode , $commercial_state , $commercial_country , $commercial_person_incharge , $commercial_person_ic , $commercial_person_position , $commercial_person_phone, $commercial_form49, $commercial_form24, $commercial_form9, $commercial_status, $commercial_application_date)

{
    $this->_commercial_id = $commercial_id;
    $this->_commercial_member_id = $commercial_member_id;
    $this->_commercial_member_number = $commercial_member_number;
    $this->_commercial_number = $commercial_number;
    $this->_commercial_company = $commercial_company;
    $this->_commercial_company_number = $commercial_company_number;
    $this->_commercial_phone = $commercial_phone; 
    $this->_commercial_address = $commercial_address;
	$this->_commercial_city = $commercial_city;
    $this->_commercial_postcode = $commercial_postcode;
    $this->_commercial_state = $commercial_state;
    $this->_commercial_country = $commercial_country;
    $this->_commercial_person_incharge = $commercial_person_incharge;
    $this->_commercial_person_ic = $commercial_person_ic;
    $this->_commercial_person_position = $commercial_person_position;
    $this->_commercial_person_phone = $commercial_person_phone;
    $this->_commercial_form49 = $commercial_form49;
    $this->_commercial_form24 = $commercial_form24;
    $this->_commercial_form9 = $commercial_form9;
    $this->_commercial_status = $commercial_status;
    $this->_commercial_application_date = $commercial_application_date;
}

}
	//get all commercial information based on the member_id
    function getCommercialbyId(){
        //global $dbConnect;
		global $member_id;
		
        $Commercial = array();
        $query = "SELECT * FROM pbmart_commercial WHERE commercial_member_id = '$member_id'";
        $result = @mysql_query($query);
        while ($row = @mysql_fetch_array($result)){
            $list = new Commercial();
            $list->setCommercial($row['commercial_id'], $row['commercial_member_id'], $row['commercial_member_number'], $row['commercial_number'], $row['commercial_company'],
                $row['commercial_company_number'], $row['commercial_phone'], $row['commercial_address'], $row['commercial_city'], $row['commercial_postcode'], $row['commercial_state'], $row['commercial_country'], $row['commercial_person_incharge'], 
                $row['commercial_person_ic'], $row['commercial_person_position'], $row['commercial_person_phone'], $row['commercial_form49'], $row['commercial_form24'], $row['commercial_form9'], $row['commercial_status'], $row['commercial_application_date']);
            $Commercial[$list->getCommercialId()] = $list;
        }
        return $Commercial;
    }
	
	function getCommercial_ID()
	{
		global $member_id;
		$query = "SELECT commercial_id, commercial_member_id FROM pbmart_commercial WHERE commercial_member_id = '$member_id'";
		$result = @mysql_query($query);
        $row = @mysql_fetch_assoc($result);
		$commercial_id = $row['commercial_id'];
		return 'COMMERCIAL'.str_pad($commercial_id,4,0000, STR_PAD_LEFT);
	}
	
	
?>