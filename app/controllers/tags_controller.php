<?php
App::import('Model','Report');  // TODO: why do I need to do this?

class TagsController extends AppController {

	var $name = 'Tags';
	var $uses = array('Tag','Report');
    
	var $paginate = array(
        'Report' => array(
                    
                    'limit' => 40
                 )
        );
	
	public function reports_with($tagId){
	    if($tagId==null){
	        //TODO: fail!
	    }
	    $this->Tag->contain('TagCategory');
	    $tag = $this->Tag->FindById($tagId);
	    if($tag==null){
	        //TODO: fail!
	    }
	    
        $this->paginate['Report']['limit'] = Configure::Read('Report.MaxPerPage');
        $this->paginate['Report']['joins'] =
                    array(
                        array(
                            'table' => 'hr_reports_tags',
                            'alias' => 'TagFilter',
                            'type' => 'INNER',
                            'conditions' => array(
                                'TagFilter.report_id = Report.id',
                                'Report.status'=>Report::STATUS_APPROVED,
                                'TagFilter.tag_id'=>$tagId
                            ),
                            'order' => array('Report.submitted_time' => 'desc')
                        )
                    );
        
        $reports = $this->paginate('Report');

        $this->set('reportList', $reports);
        $this->set('tag', $tag['Tag']);
        $this->set('tagCategory', $tag['TagCategory']);
	}

}
?>