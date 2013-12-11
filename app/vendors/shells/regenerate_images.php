<?php
App::import('lib','ImageManipulation');

/**
 * Call this (from cron)
 * > cake regenerate_images
 * @author rahulb
 *
 */
class RegenerateImagesShell extends Shell {
    
    private function isImageFile($fileName){
        if($fileName[0]=="." || $fileName=="empty"){
            return false;
        }
        return true;
    }
    
    private function removeAllImagesInDir($dir){
        $fileNames = scandir($dir);
        foreach($fileNames as $fileName){
            if(!$this->isImageFile($fileName)){
                continue;
            }
            unlink($dir.DS.$fileName);            
        }
    }
    
    private function info($str){
        $this->log($str,LOG_INFO);
        print($str."\n");
    }
    
    function main() {
        
        $imageMgmt = new ImageManipulation();
        
        $this->info("Regenerating Images:");
        
        $this->info("  Removing existing generated images:");
        $this->info("    ".Configure::read('Report.ImageSmallDir'));
        $this->info("    ".Configure::read('Report.ImageMediumDir'));
        $this->removeAllImagesInDir( Configure::read('Report.ImageSmallDir'));
        $this->removeAllImagesInDir( Configure::read('Report.ImageMediumDir'));
        
        $originalImageDir = Configure::read('Report.ImageDir');
        $this->info("  Looking for images in:");
        $this->info("    ".$originalImageDir);
        
        $fileNames = scandir($originalImageDir);
        foreach($fileNames as $fileName){
            if(!$this->isImageFile($fileName)){
                continue;
            }
            $imageMgmt->generateThumbAndMedium($fileName);
        }
    
    }
    
}

?>