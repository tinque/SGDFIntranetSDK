<?php

/**
 * --------------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <quentin.georget@gmail.com> wrote this file. As long as you retain this notice
 * you can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return. Tinque
 * --------------------------------------------------------------------------------
 */

namespace Tinque\SGDFIntranetSDKTests;


use PHPUnit_Framework_TestCase;

use Tinque\SGDFIntranetSDK\SGDFIntranetUser;

class SGDFIntranetUserTest extends PHPUnit_Framework_TestCase {
	

	public function testGetLogin()
	{
		$user = new SGDFIntranetUser('login','password');
		
		$this->assertEquals('login',$user->getLogin());
		
	}
	
	
	public function testAreCredentialsValid()
	{
		
		$user = new SGDFIntranetUser('login','password');

		$this->assertFalse($user->areCredentialsValid());
		
	}
}
