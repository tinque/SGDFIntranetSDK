<?php

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
