<?php

App::Import('Core','I18n');	// needed to localize the tags appropriately

/**
 * Call this (from the command line) to export all the reports and their linked
 * images into a folder.  The content is saved in a "data.csv" file in that folder, 
 * and all the pictures are put in an "images" folder.
 * > ./cake/console/cake export EXPORT_DIR_PATH
 * @author rahulb
 */
class ExportShell extends Shell {

    var $uses = array('Report','TagCategory','Tag','ReportsTag');
    var $isTestRun = false;
	
    function main() {

		$uploadedImagePath = WWW_ROOT.DIRECTORY_SEPARATOR."img".
			DIRECTORY_SEPARATOR."uploaded".DIRECTORY_SEPARATOR."full".DIRECTORY_SEPARATOR;

		// parse args
        $args = $this->args;
        if(count($args)!=1){
            $this->out("ERROR - you need to provide one args (the base folder to output to)");
            return;
        }

		// create output dirs
		$hrCity = Configure::Read('Gui.CityName');
		$hrCity = str_replace(" ","-",$hrCity);
		$hrCity = str_replace("/","-",$hrCity);
		$outputDirName = "hr-".$hrCity."-export-".date("Ymd_Gis");
		$outputDirPath = $args[0].DIRECTORY_SEPARATOR.$outputDirName.DIRECTORY_SEPARATOR; 
		$this->out("Exporting $hrCity reports to $outputDirPath");
		if( !$this->isTestRun) mkdir($outputDirPath);
		$outputImageDirPath = $outputDirPath.DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR;
		if( !$this->isTestRun) mkdir($outputImageDirPath);
		
		// set up the csv file
		$csvFilePath = $outputDirPath."data.csv";
		$csvFile = $this->isTestRun ? fopen('app/tmp/data.csv','w') : fopen($csvFilePath, 'w');
		$csvColumns = array("town","id","name","body","timestamp","picture","address","latitude","longitude","published","tags");
		fputcsv($csvFile, $csvColumns);

		// load and export all the approved or pending reports
		$this->out("  Loading all reports...");
		$reports = $this->Report->find('all',array("conditions"=>array("Report.status !="=>Report::STATUS_REJECTED)));
		$this->out("  Found ".count($reports)." to export: ");
		foreach($reports as $r){
			// collect the tags into a comma-separated list	
			$tags = array();
			foreach($r['Tag'] as $t){
				$tags[] = I18n::translate($t['name'],null,"tags");
			}
			// check if there is a picture, if so copy it over
			$picture = null;
			if(!empty($r['Report']['picture']) && file_exists($uploadedImagePath.$r['Report']['picture'])){
				$picture = $r['Report']['picture'];
				copy($uploadedImagePath.$picture, $outputImageDirPath.$picture);
			}
			// collect/cleanup the info for export
			$reportInfo = array(
				$hrCity,
				$r['Report']['id'],
				$r['Report']['name'],
				str_replace("\r\n","",$r['Report']['body']),
				strtotime($r['Report']['submitted_time']),
				$r['Report']['picture'],
				$r['Report']['address'],
				$r['Report']['latitude'],
				$r['Report']['longitude'],
				($r['Report']['status'])==Report::STATUS_APPROVED ? 1 : 0,
				implode(",",$tags),
				);
			// write out the row to the csv file
			fputcsv($csvFile, $reportInfo);
		}
		
		// cleanup
		fclose($csvFile);

        $this->out("  Done exporting ");
        
    }

}

?>