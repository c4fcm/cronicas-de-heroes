<?php

/**
 * Call this (from cron)
 * > cake import
 * @author rahulb
 *
 */
class ImportShell extends Shell {

    var $uses = array('Report','TagCategory','Tag','ReportsTag');
    
    function main() {

        // parse args
        $args = $this->args;
        if(count($args)!=2){
            $this->out("ERROR - you need to provide two args (the .csv and the folder with images)");
            return;
        }
        $csvFile = $args[0];
        $imageDir = $args[1];
        $this->out("Importing from ".$csvFile);
        $this->out("  Looking for images in ".$imageDir);
        
        $inserted = 0;
        $updated = 0;
        
        // parse row by row
        $f = fopen($csvFile,'r');
        $firstLine = true;
        while( ($row=fgetcsv($f))!==false ){
            if($firstLine) {
                $firstLine = false;
                continue;
            }
            // load data into model from row
            $report = array();
            $report['old_id'] = $row[0];
            $status = Report::STATUS_PENDING;
            switch($row[1]){
                case 'notapproved':
                    $status = Report::STATUS_PENDING;
                    break;
                case 'approved':
                    $status = Report::STATUS_APPROVED;
                    break;
                case 'rejected':
                    $status = Report::STATUS_REJECTED;
                    break;
                default:
                    $this->out("  UKNOWN STATUS! ".$row[1]);
                    break;
            }
            $report['status'] = $status;
            $report['body'] = $row[2];
            if(empty($report['body'])) {
                continue;
            }
            $report['picture'] = $row[3];
            if(!file_exists($imageDir.DS.$report['picture'])){
                $report['picture'] = null;
            }
            $report['submitted_time'] = date('Y-m-d H:i:s',strtotime($row[4]));
            $report['latitude'] = $row[5];
            // HACK - default location to juarez center if none set
            if(empty($report['latitude']) || $report['latitude']==0){
                $report['latitude'] = 31.70;
            }
            $report['longitude'] = $row[6];
            if(empty($report['longitude']) || $report['longitude']==0){
                $report['longitude'] = -106.425624;
            }
            $report['name'] = $row[7];
            if(empty($report['name'])) {
                $report['name'] = "Crónica";
            }
            $report['author'] = $row[8];
            $report['address'] = $row[9];
            
            // save row as new record, or update 
            $this->Report->create();
            $existingReport = $this->Report->findByOldId($report['old_id']);
            if($existingReport){
                //pr($existingReport);exit();
                $report['id'] = $existingReport['Report']['id'];
                $updated++;
            } else {
                $inserted++;
            }
            if($this->Report->save($report)){
                if($report['picture']!=null){
                    copy($imageDir.DS.$report['picture'], Configure::read('Report.ImageDir').DS.$report['picture']);
                }
                // import tags
                $tagMap = array(
                    'source'=>'tag.category.source',
                    'happened to me'=>'tag.happenedtome',
                    'eyewitness'=>'tag.eyewitness',
                    'in the news'=>'tag.inthenews',
                    'heard about'=>'tag.heardabout',
                    'category'=>'tag.category.category',
                    'lost & found'=>'tag.lostandfound',
                    'life & death'=>'tag.lifeanddeath',
                    'assistance'=>'tag.assistance',
                    'unsolicited assistance'=>'tag.assistance',
                    'other'=>'tag.other',
                    'place'=>'tag.category.place',
                    'subway'=>'tag.subway',
                    'street'=>'tag.street',
                    'taxi'=>'tag.taxi',
                );
                // category
                $category = $this->TagCategory->FindByName($tagMap['category']);
                foreach(explode(",",$row[10]) as $oldTerm){
                    if(empty($oldTerm)) continue;
                    $term = $this->Tag->FindByTagCategoryIdAndName($category['TagCategory']['id'],
                        $tagMap[strtolower(trim($oldTerm))]);
                    if(empty($term)) {
                        $this->out("ERROR: unknown Category ".$oldTerm." on old id ".$report['old_id']);
                    }
                    $this->addTagIfNew($this->Report->id, $term['Tag']['id']);
                }
                // source
                $category = $this->TagCategory->FindByName($tagMap['source']);
                foreach(explode(",",$row[11]) as $oldTerm){
                    if(empty($oldTerm)) continue;
                    $term = $this->Tag->FindByTagCategoryIdAndName($category['TagCategory']['id'],
                        $tagMap[strtolower(trim($oldTerm))]);
                    if(empty($term)) {
                        $this->out("ERROR: unknown Source ".$oldTerm." on old id ".$report['old_id']);
                    }
                    $this->addTagIfNew($this->Report->id, $term['Tag']['id']);
                }
                // place
                $category = $this->TagCategory->FindByName($tagMap['place']);
                foreach(explode(",",$row[12]) as $oldTerm){
                    if(empty($oldTerm)) continue;
                    $term = $this->Tag->FindByTagCategoryIdAndName($category['TagCategory']['id'],
                        $tagMap[strtolower(trim($oldTerm))]);
                    if(empty($term)) {
                        $this->out("ERROR: unknown Place ".$oldTerm." on old id ".$report['old_id']);
                    }
                    $this->addTagIfNew($this->Report->id, $term['Tag']['id']);
                }
            } else {
                $this->out("  ERROR: couldn't import record with old id ".$report['old_id']);
                pr($report);
                exit();
            }
        }    

        $this->out("  Inserted ".$inserted);
        $this->out("  Updated ".$updated);
        
    }
    
    public function addTagIfNew($reportId, $tagId){
        if(empty($tagId)) return false;
        $existing = $this->ReportsTag->FindByReportIdAndTagId($reportId, $tagId);
        if(!empty($existing)){
            return false;
        }
        $this->ReportsTag->Create();
        $this->ReportsTag->Save(array(
           'report_id'=>$reportId,
           'tag_id'=>$tagId
        ));
        return true;
    }
    
}

?>