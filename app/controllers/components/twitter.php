<?php
App::import('Lib', 'Twitter');

/**
 * Post reports to twitter 
 */
class TwitterComponent extends Object {

    var $controller = null;

    function startup(&$controller) {
        $this->controller = $controller;
        $this->enabled = Configure::Read('Twitter.Enabled');
        if($this->isEnabled()){
            $this->consumerKey = Configure::Read('Twitter.ConsumerKey');
            $this->consumerSecret = Configure::Read('Twitter.ConsumerSecret');
            $this->oAuthToken = Configure::Read('Twitter.OAuthToken');
            $this->oAuthTokenSecret = Configure::Read('Twitter.OAuthTokenSecret');
            $this->Twitter = new Twitter();
        }
    }

    private function isEnabled(){
        return $this->enabled;
    }
    
    /**
     * Post a report as a status update on twitter
     * @param   the report to post about
     * @return  success or failure boolean
     */
    function post($report){
        if(!$this->isEnabled()){
            return false;
        }
        if($report['Report']['status']!=Report::STATUS_APPROVED){
            return false;
        }
        // build a status update
        $status = __('twitter.statusprefix',true)." (".Configure::read("Gui.CityName")."):\n\"";
        $status.= $report['Report']['name']."\", ".__('twitter_read',true);
        $status.= ' '.Configure::read("Server.URL").'report/'.$report['Report']['id'];
        $this->log("Tweet: ".$status,LOG_DEBUG);
        // send it to twitter
        $this->Twitter->oauth($this->consumerKey, $this->consumerSecret, $this->oAuthToken, $this->oAuthTokenSecret);
        $this->Twitter->call('statuses/update', array('status' => $status));
        return true;
    }

}

?>
