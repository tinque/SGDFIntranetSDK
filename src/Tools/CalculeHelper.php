<?php


/*
 * --------------------------------------------------------------------------------
* "THE BEER-WARE LICENSE" (Revision 42):
* <quentin.georget@gmail.com> wrote this file. As long as you retain this notice
* you can do whatever you want with this stuff. If we meet some day, and you think
* this stuff is worth it, you can buy me a beer in return. Tinque
* --------------------------------------------------------------------------------
*/


namespace Tinque\SGDFIntranetSDK\Tools;

use \DateTime;

class CalculeHelper {
	
	/**
	 * 
	 * @param \DateTime $date
	 */
	static function getDateTime($date)
	{
		return DateTime::createFromFormat("d/m/Y",$date);
	}
	
	/**
	 * 
	 * @param string $date Date sous le format intranet (jj/mm/aaaa)
	 * @return \DateTime difference en now et la date
	 */
	static function getDaysBetweenDateAndNow($date)
	{
		$dateTime = CalculeHelper::getDateTime($date);
		$now = new DateTime("now");
	
		return $dateTime->diff($now);
	}
	
	/**
	 * 
	 *  @param string $date Date sous le format intranet (jj/mm/aaaa)
	 *  @return string age
	 */
	static function getAge($date)
	{
		
		$interval = CalculeHelper::getDaysBetweenDateAndNow($date);
		return $interval->format("%y");
	}
	
	static function getCodeStructureParente($codestructure)
	{
		$tmpcodestructure = $codestructure;
		
		if($codestructure[7] !=  "0")
		{
			$tmpcodestructure[7] = 0;
			$tmpcodestructure[8] = 0;
		}
		else
		{
			if($codestructure[4] !=  "0" || $codestructure[5] !=  "0" || $codestructure[6] !=  "0")
			{
				$tmpcodestructure[4] = 0;
				$tmpcodestructure[5] = 0;
				$tmpcodestructure[6] = 0;
				
			}
			else {
				$tmpcodestructure = "000000000";
			}
		}
		
		return $tmpcodestructure;
	}
	
	
}