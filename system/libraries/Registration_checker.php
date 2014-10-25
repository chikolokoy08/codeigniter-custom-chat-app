<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Registration Checker
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Registration Checker
 * @author		Julius Estebar
 * @link		- For Review - 
 */
class CI_Registration_checker {

	function check_format($name,$format,$value){
	
		if(strlen($format) != strlen($value))
			return $name . ' mismatch.';
		
		
		for($i = 0 ; $i < strlen($format) ; $i++){
		
			if(strtoupper($format[$i]) == 'X' && !is_numeric($value[$i])){
					return $name . ' invalid format.';
			}
			if($format[$i] == '-' && !$value[$i] == '-'){
					return $name . ' invalid format.';
			}

		}	
		
	
	}


}
// END Registration Checker Class

/* End of file Registration_checker.php */
/* Location: ./system/libraries/Registration_checker.php */