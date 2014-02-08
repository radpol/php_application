<?php
	
class Validation 
{
	/**
	 * Validate email address
	 * @param string $mail , 
	 * @return boolean
	 */
	public function validEmailAdress($mail)
	{
		$isValid  = TRUE;
		if($this->_emailAddressFormat($mail) === TRUE)
			$isValid  = TRUE;
		return $isValid;
	}
	
	/**
	 * 
	 * @param unknown $mail
	 */
	private function _emailAddressFormat($mail)
	{
		
	}
}	




