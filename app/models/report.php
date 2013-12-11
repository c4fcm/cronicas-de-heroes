<?php
class Report extends AppModel {
	
	// various constants for tracking moderation approval status
	const STATUS_PENDING = 0;
	const STATUS_APPROVED = 1;
	const STATUS_REJECTED = 2;

	const MAX_TEASER_BODY_LEN = 230;
	
	var $name = 'Report';
	
	var $actsAs = array('Containable');
	
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'body' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

    var $hasAndBelongsToMany = array(
        'Tag'
    );
    
	/**
	 * How many reports are pending approval?
     * TODO: cache this somewhere so we don't have to run it every page hit!
     */
    public function pendingCount(){
        return $this->find('count',array('conditions'=>array('status'=>Report::STATUS_PENDING)));
    }
    
    /**
     * How many reports have been approved?
     * TODO: cache this somewhere so we don't have to run it every page hit!
     */
    public function approvedCount(){
        return $this->find('count',array('conditions'=>array('status'=>Report::STATUS_APPROVED)));
    }
    
    /**
     * Set some defaults before saving a new report
     */
    function beforeSave() {
        // default to pending moderation, or approved, based on config setting in app/config/heroreports.php
        if(!isset($this->data['Report']['status']) || empty($this->data['Report']['status'])){
            $autoPublish = Configure::read('Report.PublishedAutomically');
            $defaultStatus = Report::STATUS_PENDING;
            if($autoPublish) {
                $defaultStatus = Report::STATUS_APPROVED;
            }
            $this->data['Report']['status'] = $defaultStatus;
        }
        // default submit time to now
        if(!array_key_exists('submitted_time',$this->data['Report']) || 
                empty($this->data['Report']['submitted_time'])){
            $this->data['Report']['submitted_time'] = date('Y-m-d H:i:s');
        }
        // change returns to <br>s
        if(array_key_exists('body',$this->data['Report'])) {
            $this->data['Report']['body'] = str_replace("\\n","<br/>",$this->data['Report']['body']);
        }
        return true; 
    }

    /**
     * Internal helper to quickly change the status of a report
     * @param unknown_type $id
     * @param unknown_type $newStatus
     */
    protected function changeStatus($id=null,$newStatus){
        if ($id) {
            // save the new status
            $this->id = $id;
            $this->saveField('status', $newStatus);
        }
    }
    
    /**
     * Public method to quickly mark a report as approved
     * @param $id
     */
    public function approve($id=null){
        $this->changeStatus($id, Report::STATUS_APPROVED);
    }

    /**
     * Public method to quickly mark a report as pending approval
     * @param $id
     */
    public function pending($id=null){
        $this->changeStatus($id, Report::STATUS_PENDING);
    }
    
    /**
     * Public method to quickly mark a report as not approved
     * @param $id
     */
    public function reject($id=null){
        $this->changeStatus($id, Report::STATUS_REJECTED);
    }

    /**
     * Remove the picture associated with a report, and the files 
     * generated based on it
     * @param $id
     */
    public function removePicture($id){
        $report = $this->FindById($id);
        $currentPicture = $report['Report']['picture'];
        // delete any files that are there already
        if(!empty($currentPicture)){
            $parts = explode(".",$currentPicture);
            $path = Configure::read('Report.ImageDir').DS.$currentPicture;
            $smallPath = Configure::read('Report.ImageSmallDir').DS.$parts[0].".jpg";
            $mediumPath = Configure::read('Report.ImageMediumDir').DS.$parts[0].".jpg";
            if(file_exists($path)) unlink($path);
            if(file_exists($smallPath)) unlink($smallPath);
            if(file_exists($mediumPath)) unlink($mediumPath);
            $this->id = $id;
            $this->saveField('picture',"");
        }
    }

    /**
     * Return results configured for display on the map.  Important to cache these
     * to speed up homepage load time.  Also make sure to reset the cache whenever you 
     * change the status of a report.
     * 
     * @param   $resetCache     use true if you want to force a rebuild of the cache 
     * @return  cached list of approved Report records (only some fields loaded)
     */
    public function cachedAllForMap($resetCache=false){
        $approvedReports = Cache::read("reports_for_map");
        if( ($resetCache==true) || ($approvedReports==null) ){
            $this->contain();
            $approvedReports = $this->find('all',array(
                'fields'=>array('longitude','latitude','name','picture','body','id'),
                'conditions'=>array('Report.status'=>Report::STATUS_APPROVED),
                'order'=>array('submitted_time'=>'DESC')
                ));
            // reduce page size
            for($i=0;$i<count($approvedReports);$i++){
                $body = $approvedReports[$i]['Report']['body'];
                if(strlen($body)>Report::MAX_TEASER_BODY_LEN){
                    $shorterBody = substr($body,0,Report::MAX_TEASER_BODY_LEN)."...";
                    $approvedReports[$i]['Report']['body'] = $shorterBody;
                }
            }
            Cache::write("reports_for_map",$approvedReports);
        }
        return $approvedReports;
    }
    
    /**
     * Callback triggered after a report is saved.
     * 
     * @see     http://book.cakephp.org/view/1053/afterSave
     * @param   $created  true if this was a new report
     */
    public function afterSave($created) {
        // and now reset the approved cache (this is a little aggressive, but that's ok)
        $this->cachedAllForMap(true);
    }

}
?>