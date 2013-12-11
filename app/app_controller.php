<?php
/**
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {

	// the version of the app
    const APP_VERSION = "0.1";
    
    // the variable used to save the user model object in the session
    const SESSION_USER_ID_VAR = "userId";
    
    // the variable used to save the view language in the session
    const SESSION_LOCALE = "locale"; 
    
    // variables exposed to every view
    const VIEW_SETUP_ERRORS_VAR = "setupErrors";
    const VIEW_LOCALES_VAR = "locales";
    const VIEW_PENDING_COUNT_VAR = "pendingApprovalCount";
    const VIEW_APPROVED_COUNT_VAR = "approvedCount";
    const VIEW_LOGGED_IN_VAR = "isLoggedIn";
    const VIEW_IS_MODERATOR_VAR = "isModerator";
    const VIEW_IS_ADMIN_VAR = "isAdmin";
    const VIEW_USER_VAR = "user";
    const VIEW_APP_VERSION_VAR = "appVersion";
    const VIEW_IS_HOMEPAGE = "isHomepage";
    const VIEW_ALL_TAG_CATEGORIES = "allTagCategories";
    
    // use these variables in your controllers to set security levels
    const CONTROLLER_AUTHENTICATES_VAR = "authenticates";
    
    var $uses = array('User','Report','TagCategory','Tag');
    var $helpers = array('Html','Javascript','Time', 'Form','Session','Heroreports');
    var $components = array('RequestHandler','Session','DebugKit.Toolbar');
    //var $layout = "lostinboston";
    
    var $view = 'Theme';
    var $theme = 'generic';
    var $layout = 'standard';
    
    // keep the current logged in user obj around, in case we need it
    var $currentUser = null;
    
    /**
     * Calling this as the first thing in a controller method forces the user 
     * to login before seeing a page
     */
    protected function checkSession() {
        // If the session info hasn't been set force them to the log in page
        if (!$this->isLoggedIn()) {
            $this->log("failed session check!",LOG_DEBUG);
            if($this->RequestHandler && $this->RequestHandler->isAjax()) {
                // handle session timeout on ajax requests differently to not
                // get embedded login page
                $this->layout('ajax');
            } else {
                $this->redirect(array('controller'=>'users','action'=>'login'));
            }
            return false;    
        }
        return true;
    }

    function getSetupErrorMsgs(){
        $msgs = array();
        if(!is_writable(Configure::read("Report.ImageDir"))){
            $msgs[] = __("error.cantwritetodir",true)." ".Configure::read("Report.ImageDir");   
        }
        if(!is_writable(Configure::read("Report.ImageMediumDir"))){
            $msgs[] = __("error.cantwritetodir",true)." ".Configure::read("Report.ImageMediumDir");   
                    }
        if(!is_writable(Configure::read("Report.ImageSmallDir"))){
            $msgs[] = __("error.cantwritetodir",true)." ".Configure::read("Report.ImageSmallDir");   
        }
        return $msgs;
    }
    
    /**
     * Based on the lack of presence of variables on this controller, do
     * the appropriate security checks.  Also adds in the default view variables. 
     */
    function beforeFilter() {
        $this->set(AppController::VIEW_LOGGED_IN_VAR, false);
    	
        // figure out what theme to use
        $this->theme = Configure::read('Gui.ThemeName');
        
        // check for any setup errors
        $setupErrors = $this->getSetupErrorMsgs();
        $this->set(AppController::VIEW_SETUP_ERRORS_VAR, $setupErrors);
        
        // expose any view constants
        $this->set(AppController::VIEW_APP_VERSION_VAR, AppController::APP_VERSION);
        $this->set(AppController::VIEW_APPROVED_COUNT_VAR, $this->Report->approvedCount());
        $this->set(AppController::VIEW_PENDING_COUNT_VAR, $this->Report->pendingCount());
        $this->set(AppController::VIEW_LOGGED_IN_VAR, $this->isLoggedIn());
        $this->set(AppController::VIEW_IS_ADMIN_VAR, $this->isAdmin());
        $this->set(AppController::VIEW_IS_MODERATOR_VAR, $this->isModerator());
        $this->set(AppController::VIEW_IS_HOMEPAGE, false);
        $this->set(AppController::VIEW_ALL_TAG_CATEGORIES, $this->TagCategory->cachedFindAll());
        if($this->isLoggedIn()) {
            $this->set(AppController::VIEW_USER_VAR, $this->getUser());
        } else {
            $this->set(AppController::VIEW_USER_VAR, null);
        }
                   
        // limit certain controllers to logged-in people
        $authVarName = AppController::CONTROLLER_AUTHENTICATES_VAR;
        if(array_key_exists($authVarName,$this) && $this->$authVarName==true) {
            $this->checkSession();
        }
        
        // limit certain actions to admin (if actions starts with admin_ routing prefix)
        if(strpos($this->action,"admin_")===0){
            if(!$this->isAdmin()) {
                $this->redirect(array('admin'=>false, 'controller'=>'pages','action'=>'not_permitted'));
                return;
            }
        }
        
        // limit certain actions to moderators (if actions starts with moderator_ routing prefix)
        if(strpos($this->action,"moderator_")===0){
            if(!$this->isModerator()) {
                $this->redirect(array('moderator'=>false, 'controller'=>'pages','action'=>'not_permitted'));
                return;
            }
        }
        
        // set the language for the logged in moderator/admin
        if($this->isLoggedIn()){
            $locales = $this->availableLocales();
            $this->set(AppController::VIEW_LOCALES_VAR,$locales);
            $user = $this->getUser();
            $language = $user['User']['language'];
            if(!empty($language)){
                Configure::Write('Config.language', $language);
            }
        }
        
        // set the language if they have a locale set and aren't logged in
        if($this->hasLocaleSet()){
            $locale = $this->getDesiredLocale();
            if(!empty($locale)){
                Configure::Write('Config.language', $locale);
            }
        }
        
    }    
    
    /**
     * List all the available locales (l10n)
     */
    protected function availableLocales(){
        $locales = array();
        $dir = APP.'locale'.DS;
        $fileList = scandir($dir);
        foreach($fileList as $name){
            if(strpos($name,".")===false){
                if(is_dir($dir.$name)){
                    $locales[$name] = $name;
                }
            }
        }
        return $locales;        
    } 
    
    /**
     * Get the user id of the logged in user, null if not logged in.
     */
    protected function getUserId() {
        if ( !$this->isLoggedIn() ) return null;
        $userId = $this->Session->read(AppController::SESSION_USER_ID_VAR);
        return $userId;
    }
    
    protected function hasLocaleSet() {
        return $this->Session->check(AppController::SESSION_LOCALE);
    }
    
    protected function isAdmin() {
        return $this->User->isAdmin($this->getUser());
    }
    
    protected function isModerator() {
        // for now, all registered users are moderator
        return $this->isLoggedIn();
    }
    
    /**
     * Return if there is a user logged in.
     * TODO: more security here would be good (ie. check for valid session, valid user, etc)
     */
    protected function isLoggedIn() {
        return $this->Session->check(AppController::SESSION_USER_ID_VAR);
    }
    
    protected function getDesiredLocale() {
        if(!$this->hasLocaleSet()) return null;
        return $this->Session->read(AppController::SESSION_LOCALE);
    }
    
    /**
     * Get the currently logged in user.  Null if not logged in.
     */
    protected function getUser() {
        if( !$this->isLoggedIn() ) return null;
        if ($this->currentUser!=null ) return $this->currentUser;
        $this->currentUser = $this->User->FindById( $this->getUserId() );
        return $this->currentUser;
    }
    
}
?>