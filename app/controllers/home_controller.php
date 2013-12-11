<?php
class HomeController extends AppController {

	var $name = 'Home';
	var $uses = array('Report','ReportStatusHistory');
    
	public function index(){
	    $this->set(AppController::VIEW_IS_HOMEPAGE, true);
	    
        $approvedReports = $this->Report->cachedAllForMap();

        $this->set('reportList',$approvedReports);     
        
        $this->set('recentReportList',array_slice($approvedReports,0,
            Configure::read('Homepage.RecentReportCount')));
	}
      
}
?>