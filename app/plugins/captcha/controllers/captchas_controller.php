<?php

App::import('lib','captcha.securimage');

class CaptchasController extends CaptchaAppController {

    var $uses = array();
	var $name = 'Captchas';

	/**
	 * Call this to show a captcha image.  Since this renders an image, not a 
	 * webapge, the url to this should probably be the source of an img tag
	 * in a view.
	 */
	public function image(){
	    $si = new Securimage();
        $si->basepath = APP."plugins".DS."captcha".DS."libs".DS;
	    $si->use_gd_font = true;
        $si->image_width = 275;
        $si->image_height = 90;
        $si->perturbation = 0.9;  //1.0 = high distortion, higher numbers = more distortion
        $si->image_bg_color = new Securimage_Color("#0099CC");
        $si->text_color = new Securimage_Color("#EAEAEA");
        $si->text_transparency_percentage = 65;  // 100 = completely transparent
        $si->num_lines = 2;
        $si->line_color = new Securimage_Color("#0000CC");
        $si->signature_color = new Securimage_Color(rand(0, 64), rand(64, 128), rand(128, 255));
        $si->image_type = SI_IMAGE_JPEG;
        $si->show();	    
	}
	
	public function audio(){
        $si = new Securimage();
        $si->audio_format = 'mp3';
        $si->outputAudioFile();
	}
	
	/**
	 * Call this with requestAction from a controller to see if the user
	 * input matches the captcha
	 * @param  string  $str    what the user things the captcha says
	 */
	public function check($str){
	    $si = new Securimage();
	    return ($si->check($str)!=false);
	}
	
}
?>