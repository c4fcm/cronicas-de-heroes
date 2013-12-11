<?php

/**
 * Call this (from cron)
 * > cake import_voicemail
 * @author rahulb
 *
 */
class ImportVoicemailShell extends Shell {

    var $uses = array('Report');
    
    function main() {

        if(Configure::Read('Voicemail.Enabled')==false){
            return;
        }
        
        $this->sourceDir = Configure::Read('Voicemail.SourceFolder');
        $this->log("Importing from ".$this->sourceDir,LOG_INFO);

        if ($handle = opendir($this->sourceDir)) {
            while (false !== ($file = readdir($handle))) {
                if ( (strlen($file)>4) && 
                        ($this->strEndsWith($file,".mp3") ||  $this->strEndsWith($file,".wav") ) ) {
                    $this->log("  ".$file,LOG_INFO);
                    $fileModTime = filemtime($this->sourceDir.DS.$file);
                    $movedFile = $this->moveVoicemailFileToPublicDir($file);
                    if($movedFile) {
                        $reportCreated = $this->createReportFromVoicemailFile($file, $fileModTime);
                        if(!$reportCreated){
                            $this->log("! Failed to save report for voicemail file $file");
                        }
                    }
                }
            }
            closedir($handle);
        }
                
    }
    
    function moveVoicemailFileToPublicDir($filename){
        $sourceFile = $this->sourceDir.DS.$filename;
        if(!file_exists($sourceFile)){
            return false;
        } 
        $destinationDir = Configure::Read('Voicemail.PublicFolder');
        $destinationFile = $destinationDir.DS.$filename;
        $worked = copy($sourceFile, $destinationFile);
        if($worked){
            unlink($sourceFile);
        }
        return $worked;
    }
    
    function createReportFromVoicemailFile($filename, $createTime){
        
        $report = array();
        $report['body'] = __('voicemail.needstranscription',true);
        $report['audio_file'] = $filename;
        $report['submitted_time'] = date('Y-m-d H:i:s',$createTime);
        $report['name'] = __('voicemail.new',true);
        $report['author'] = __('noun.anonymous',true);

        $this->Report->create();
        return $this->Report->save($report);
    }
    
    function strEndsWith($str,$test){
        return substr_compare($str, $test, -strlen($test), strlen($test)) === 0;
    }
    
}

?>