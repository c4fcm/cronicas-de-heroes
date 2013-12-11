<?php
/* Captchas Test cases generated on: 2011-02-18 12:20:32 : 1298049632*/
App::import('Controller', 'Captcha.Captchas');

class TestCaptchasController extends CaptchasController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class CaptchasControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->Captchas =& new TestCaptchasController();
		$this->Captchas->constructClasses();
	}

	function endTest() {
		unset($this->Captchas);
		ClassRegistry::flush();
	}

}
?>