<?php
App::import('ConnectionManager'); 
App::import('Lib','S3');

/**
 * Simple backup helper that forks out to mysqldump 
 */
class BackupShell extends Shell {

    /**
     * Save a timestamped backup of the database to the app/tmp/db_backups directory
     */
    function main() {
        $path = $this->_writeBackup();
        if($path!=null){
            $this->_uploadToS3();
        }
    }
    
    private function _writeBackup(){
        $c = ConnectionManager::getInstance()->config->default; 
        $path = TMP . 'db_backups'.DS.'heroreports_backup_'.date("Ymd_His").'.sql.gz';
        $this->out("Writing backup dump file to $path");
        $command = exec($c = "mysqldump -u {$c['login']} --password={$c['password']} -h {$c['host']} {$c['database']} | gzip > $path"); 
        if (!file_exists($path)) { 
            $this->out("Couldn't create backup, aborting.");
            return null; 
        }
        return $path;
    }
    
    private function _uploadToS3(){
        //http://undesigned.org.za/files/s3-class-documentation/index.html
        //TODO: implement this using the S3 library
        //$s3 = new S3(awsAccessKey, awsSecretKey);
        //$s3->putObject($string, $bucketName, $uploadName, S3::ACL_PUBLIC_READ)
    }
    
}
?>