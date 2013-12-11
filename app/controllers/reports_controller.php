<?php
App::import('lib','ImageManipulation');

class ReportsController extends AppController {

	var $name = 'Reports';
	var $uses = array('Report','ReportStatusHistory','Tag','TagCategory','ReportsTag');
    var $components = array('Twitter');
	
	var $paginate = array(
           'Report'=>array(
                'limit' => 40,
                'order' => array('Report.submitted_time' => 'desc')
                ),
           'ReportStatusHistory'=>array(
                'limit' => 40,
                'order' => array('ReportStatusHistory.time' => 'desc')
                ),
           'ReportsTag'=>array(
                'limit' => 40,
                'order' => array('Report.submitted_time' => 'desc')
                )
                
        );
	
    public function index(){
        $this->redirect('browse');
    }
        
	public function browse(){
		$this->paginate['Report']['limit'] = Configure::Read('Report.MaxPerPage');
	    
        $approvedReports = $this->paginate('Report',
            array('Report.status'=>Report::STATUS_APPROVED));
    
        $this->set('reportList',$approvedReports);     
		
	}
	
	public function search(){
	    if($this->data) {
            $searchStr = $this->data['s'];
            $this->paginate['Report']['limit'] = Configure::Read('Report.MaxPerPage');
            
            // WARN: Does not scale well at all!
            $conditions = array();
            if(!$this->isModerator()){
                $conditions['Report.status']=Report::STATUS_APPROVED;
            }
            $conditions['OR'] = array(
                        'Report.name LIKE'=>"%".addslashes($searchStr)."%",
                        'Report.body LIKE'=>"%".addslashes($searchStr)."%",
                      ); 
            $reportList = $this->paginate('Report', $conditions);
            
            $this->set('searchStr', $searchStr);
            $this->set('reportList', $reportList);   
	    } else {
	        $this->redirect('browse');
	    }
	}
	
	/**
	 * For supporting old links, on twitter and other places.
	 * @param unknown_type $oldId
	 */
	public function view_by_old_id($oldId) {
	    if($oldId==null) {
            $this->redirect('browse');
        }
	    $report = $this->Report->findByOldId($oldId);
	    if(empty($report)) {
            $this->redirect('browse');
        }
        $this->redirect(array('action'=>'view',$report['Report']['id']));
	}
	
	public function view($id=null){
	    if($id==null) {
	        $this->redirect('browse');
	    }
	    
        $report = $this->Report->findById($id);
        if($report==null){
            $this->redirect('index');
        }
        $this->set('report',$report);

        $this->TagCategory->contain();
        $tagCategories = $this->TagCategory->Find('all');
        $this->set('allTagCategories',$tagCategories);
        
        $this->ReportStatusHistory->contain('User');
        $history = $this->ReportStatusHistory->find('all',
            array(
                'conditions'=>array('ReportStatusHistory.report_id'=>$report['Report']['id']),
                'order'=>array('ReportStatusHistory.time'=>'desc')));
        $this->set('statusHistoryList',$history);
        
	}
	
	public function map(){
        
        $approvedReports = $this->Report->cachedAllForMap();
	    	        
        $this->set('reportList',$approvedReports);     
	    
	}
	
	private function isTryingToUploadImage($metadata){
        return !empty($metadata['tmp_name']);
	}
	
	/**
	 * Return true if the metadata for an uploaded file is ok (ie. it verifies
	 * and is ready to save).
	 * @param unknown_type $metadata
	 */
	private function getUploadedImageError($metadata){
	    $allowedMimeTypes = array('image/jpeg','image/gif','image/png');
        if($metadata['error']!=0){
            return __('report.image.error',true);
        }
	    if(!in_array($metadata['type'],$allowedMimeTypes)){
	        return __('report.image.error.invalidtype',true);
	    }
	    if($metadata['size']>Configure::Read('Report.MaxImageSizeBytes')){
            return __('report.image.error.toobig',true);
	    }
	    return null;
	}
	
	/**
	 * Save an uploaded image to a report, and move it to the right place in the
	 * file system.
	 * @param unknown_type $report
	 * @param unknown_type $imageMeta
	 */
	private function saveUploadedImageToReport($report,$imageMeta){
        if(!$this->isTryingToUploadImage($imageMeta)){
            return false;
        }
	    // move the file to the right place for long-term storage
	    $typeParts = explode("/",$imageMeta['type']);
	    $filename = $report['Report']['id'].".".$typeParts[1];
	    $destFile = Configure::read('Report.ImageDir').DS.$filename;
        $this->log($filename,LOG_DEBUG);
        $this->log($destFile,LOG_DEBUG);
	    $success = move_uploaded_file($imageMeta['tmp_name'],$destFile);
	    $this->log($success,LOG_DEBUG);
	    if($success) {
    	    // save it to the report
    	    $report['Report']['picture'] = $filename;
    	    $this->Report->save($report);
    	    $imageMgmt = new ImageManipulation();
    	    $imageMgmt->generateThumbAndMedium($filename);
    	    return true;
        }
        return false;
	}
	
    public function create(){
        
        $this->set('outsideMapBoundaryErrMsg',__('error.outsidemapboundary',true));
        
        $allTagCategories = $this->TagCategory->find('all');
        $this->set('allTagCategories',$allTagCategories);
        
        // save the new report if it is a post
        if (!empty($this->data)) {
            if(Configure::Read('Gui.RequireCaptcha')) {
                // check the captcha
                $captchaOk = $this->requestAction(array('plugin'=>'captcha', 'controller' => 'captchas', 
                    'action' => 'check'), array('pass'=>array($this->data['Report']['captcha'])));
                if(!$captchaOk){
                    $this->Session->setFlash( __('report.captchafailed',true));
                    return;
                }
            }
            // validate any image attached
            $imageMeta = $this->data['Report']['imageMeta'];
            if($this->isTryingToUploadImage($imageMeta)){
                $imageErrorStr = $this->getUploadedImageError($imageMeta);
                if ($imageErrorStr!=null) {
                    $this->Session->setFlash($imageErrorStr);
                    return;
                }
            }
            // save the new report
            if ($this->Report->save($this->data)) {
                // save the associate image now
                $report = $this->Report->findById($this->Report->id);
                if($this->isTryingToUploadImage($imageMeta)){
                    $this->saveUploadedImageToReport($report,$imageMeta);
                }
                // save all the tags on it
                foreach($this->data['Report'] as $key=>$tagId){
                    if(strpos($key,"category")===0){
                        $this->_addTagToReport($this->Report->id,$tagId);
                    }
                }
                // record that it was created
                $this->saveStatusHistoryItem($report['Report']['id'],$report['Report']['status'],true);
                // post to twitter if it is auto-approved
                if($report['Report']['status']==Report::STATUS_APPROVED){
                    $this->Twitter->post($report);
                }
                // redirect the user
                $this->Session->setFlash(__('report.aftersubmission',true));
                $this->redirect(array('action' => 'index'));
            }
        }
        
    }
    
    public function moderator_index(){
        $this->redirect(array('action'=>'pending'));
    }

    public function moderator_all() {
        $pendingReports = $this->paginate('Report');
    
        $this->set('reportList',$pendingReports);     
    }
    
    public function moderator_approved() {
        $pendingReports = $this->paginate('Report',
            array('Report.status'=>Report::STATUS_APPROVED));
    
        $this->set('reportList',$pendingReports);     
    }
    
    public function moderator_pending() {
        $pendingReports = $this->paginate('Report',
            array('Report.status'=>Report::STATUS_PENDING));
    
        $this->set('reportList',$pendingReports);     
    }
    
    public function moderator_rejected(){

        $rejectedReports = $this->paginate('Report',
            array('Report.status'=>Report::STATUS_REJECTED));
    
        $this->set('reportList',$rejectedReports);     
        
    }

    private function saveStatusHistoryItem($reportId, $newStatus, $anonymousUser){
        $userId  = ($anonymousUser) ? null : $this->getUserId();
        $statusHistory = array(
            'report_id'=>$reportId,
            'user_id'=>$userId,
            'status'=>$newStatus,
            'time'=> date('Y-m-d H:i:s'),
        );
        $worked = $this->ReportStatusHistory->save($statusHistory);
    }
    
    public function moderator_requeue(){
        // queue it
        $reportId = $this->data['Report']['id'];
        $this->Report->pending($reportId);
        // save the status change
        $this->saveStatusHistoryItem($reportId,Report::STATUS_PENDING,false);
        // send them back to the list
        $this->redirect(array('controller'=>'reports','action'=>'index'));
        
    }
    
    public function moderator_approve(){
        // queue it
        $reportId = $this->data['Report']['id'];
        $this->Report->approve($reportId);
        // save the status change
        $this->saveStatusHistoryItem($reportId,Report::STATUS_APPROVED,false);
        // post to twitter
        $report = $this->Report->findById($reportId);
        $this->Twitter->post($report);
        // send them back to the list
        $this->redirect(array('controller'=>'reports','action'=>'index'));
    }

    public function moderator_reject(){
        // queue it
        $reportId = $this->data['Report']['id'];
        $this->Report->reject($reportId);
        // save the status change
        $this->saveStatusHistoryItem($reportId,Report::STATUS_REJECTED,false);
        // send them back to the list
        $this->redirect(array('controller'=>'reports','action'=>'index'));
    }
    
    public function moderator_edit($id){
        
        $this->set('outsideMapBoundaryErrMsg',__('error.outsidemapboundary',true));
        $allTagCategories = $this->TagCategory->find('all');
        $this->set('allTagCategories',$allTagCategories);
        
        if (empty($this->data)) {
            $this->data = $this->Report->FindById($id);
            $this->set('report',$this->data); 
        } else {
            $this->set('report',$this->data); 
            // validate any image attached
            $imageMeta = $this->data['Report']['imageMeta'];
            if($this->isTryingToUploadImage($imageMeta)){
                $imageErrorStr = $this->getUploadedImageError($imageMeta);
                if ($imageErrorStr!=null) {
                    $this->Session->setFlash($imageErrorStr);
                    return;
                }
            }
            // save the changes
            if ($this->Report->save($this->data)) {
                // save the associate image now
                $report = $this->Report->findById($this->Report->id);
                if($this->isTryingToUploadImage($imageMeta)){
                    if(!empty($this->data['Report']['picture'])) {
                        $this->Report->removePicture($this->Report->id);
                    }
                    // save the new image
                    $this->saveUploadedImageToReport($report,$imageMeta);
                }
                // save all the tags on it
                $this->ReportsTag->deleteAll(array(
                    'report_id'=>$this->Report->id
                ));
                foreach($this->data['Report'] as $key=>$tagId){
                    if(strpos($key,"category")===0){
                        $this->_addTagToReport($this->Report->id,$tagId);
                    }
                }
                $this->Session->setFlash(__('report.aftersave',true));
                $this->redirect(array('moderator'=>false,'action' => 'view',$id));
            }
        }
        
    }
    
    public function moderator_delete(){
        
        $id = $this->data['Report']['id']; 
        $this->Report->Delete($id);

        // redirect user
        $this->Session->setFlash(__('report.afterdelete',true));
        $this->redirect(array('action' => 'index'));

    }    
           
    public function moderator_removePicture($id){
        
        $this->Report->removePicture($id);
        
        // redirect user
        $this->Session->setFlash(__('report.afterRemovedPicture',true));
        $this->redirect(array('moderator'=>false,'action' => 'view',$id));
    }    
       
    public function moderator_recentActivity(){
        $statusHistoryList = $this->paginate('ReportStatusHistory');
        $this->set('statusHistoryList',$statusHistoryList);
    }

    public function _addTagToReport($reportId, $tagId){
        if(empty($tagId)) return false;
        if(empty($reportId)) return false;
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