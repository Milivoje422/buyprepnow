<?php
/**
* ICEPAY Library for PHP
* (c) 2009 ICEPAY
*
* This file contains the ICEPAY Library for PHP.
*
* @author ICEPAY.eu (support@icepay.eu)
* @version 1.0
*/
class ICEPAY_Wire extends ICEPAY
{
	public function Pay( $language = NULL, $currency = NULL, $amount = NULL, $description = NULL )
	{
		$this->issuer			= 'WIRE';
		$this->country			= "00";
		$this->assignLanguage	( $language );
		$this->assignCurrency	( $currency );
		$this->assignAmount		( $amount );
		$this->description		= $description;
		$this->paymentMethod	= "WIRE";

		return $this->postRequest( $this->basicMode(), $this->prepareParameters() );
	}
}

?>