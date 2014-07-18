<?php

/*
 * --------------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <quentin.georget@gmail.com> wrote this file. As long as you retain this notice
 * you can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return. Tinque
 * --------------------------------------------------------------------------------
 */

namespace Tinque\SGDFIntranetSDK;

use \Exception;

class SGDFIntranetError extends Exception {
	
	/**
	 * 
	 * @param string $message Message d'erreure
	 * @param integer $code code d'erreur
	 */
	public function __construct($message, $code = E_ERROR)
	{
		parent::__construct($message, $code);
	}
	
	public function __toString()
	{
		return $this->message;
	}
}