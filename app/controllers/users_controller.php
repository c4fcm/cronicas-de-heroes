<?php
/**
 * Allow users to login, signout, and optionally signup for new accounts.
 * @author rahulb
 *
 */
class UsersController extends AppController {

    var $name = 'Users';
    var $authenticates = false;
    
    var $uses = array("User");
    
    // where do we redirect to after someone has logged in successfully?
    var $postLoginController = "reports";
    
    /**
     * Redirect to the right homepage 
     */
    public function index() {
        $this->redirect(array('controller'=>'home'));
    }
    
    /**
     * Allow the user to signup themselves, if the config var says that is ok
     */
    public function signup() {
        
        // make sure self-signup is allowed
        $allowSelfSignup = Configure::read('User.AllowSelfSignup');
        if($allowSelfSignup==false) {
            $this->redirect('login');
            return;
        }

        // if it is a post, create and log them in
        if (!empty($this->data)) {
            $this->User->set($this->data);

            if ($this->User->validates()) {
                if ($this->User->save($this->data)) {
                    $user = $this->User->FindById($this->User->id);
                    //log them in
                    $this->createSession($this->User->id);
                    //send them to the homepage
                    $this->redirect(array('controller'=>$this->postLoginController));
                } else {
                    //$this->set(AppController::VIEW_ERRORS_VAR, $this->User->validationErrors);
                }
            } else {
                //$this->set(AppController::VIEW_ERRORS_VAR, $this->User->validationErrors);
            }
        }           
        
    }
    
    /**
     * Helper to set the language and send them back to where they were
     * with the new language
     * @param unknown_type $lang
     */
    public function set_language($lang){
        $referrer = $this->referer("/",true);
        // validate
        if(in_array($lang,$this->availableLocales())) {
            $this->Session->write(AppController::SESSION_LOCALE, $lang);
        }
        $this->redirect($referrer);
    }

    /**
     * Handle attempts to login
     */
    public function login() {
    	
        // if they're logged in already, redirect them
        if ( $this->isLoggedIn() ) {
            $this->redirect(array('controller'=>$this->postLoginController));
        }
        
        // handle login attempts
        if (!empty($this->data)) {
            $this->User->set($this->data);
            if ($this->User->validates()) {
                if ($this->User->verifyLogin($this->data)) {
                    $user = $this->User->FindByUsername($this->data['User']['username']);
                    $this->createSession($user['User']['id']);
                    // logged in success, forward to dashboard
                    $this->redirect(array('controller'=>$this->postLoginController));
                } else {
                	// bad user/pass
                    $this->Session->setflash(__("error.badlogin",true));
                }
            } else {
            	// didn't enter enough data to the form
            	$this->Session->setflash(__("error.badlogin",true));
            }
        }
    }

    /**
     * Delete the session if they want to log out
     */
    public function logout() {
        $this->deleteSession();
        $this->redirect('/');
    }

    /**
     * Delete the session, logging the user out.
     */
    private function deleteSession() {
        $this->Session->delete(AppController::SESSION_USER_ID_VAR);
    }

    /**
     * Create the session by saving the user id to it (note: destroys any old session)
     * @param unknown_type $userData
     */
    private function createSession($userId) {
        $this->deleteSession();
        $this->Session->write(AppController::SESSION_USER_ID_VAR, $userId);
    }

    /** 
     * List all the users for an admin
     */ 
    public function admin_index(){
        
        // list all users
        $allUsers = $this->User->find('all',array('order'=>'username'));
        $this->set("users",$allUsers);
        
    }
    
    /**
     * Lets an admin create a new user
     */
    public function admin_create() {
        
        if (!empty($this->data)) {
            if ($this->User->save($this->data)) {
                // redirect user
                $this->Session->setFlash(__('user.aftercreate',true));
                $this->redirect(array('action' => 'index'));
            }
        }
        
    }    
    
    /**
     * Lets an admin edit a user
     * @param $userId
     */
    public function admin_edit($userId) {

        $theUser = $this->User->findById($userId);
        $this->data = $theUser;
        $this->data['User']['password'] = "";
                
    }
    
    /**
     * Save changes to a user
     * @param $userId
     */
    public function admin_save($userId) {
        
        // if it is a post, save the new install
        if (!empty($this->data)) {
            $user = $this->User->find($this->data['User']['id']);
            if( strlen($this->data['User']['password'])==0 ) {
                unset($this->data['User']['password']);
                //print_r($this->data);exit();
            }
            $this->data['User']['id'] = $userId;
            
            // try to save the new user data 
            if($this->User->save($this->data)) {
                $this->Session->setFlash(__('user.aftersave',true));
                $this->redirect('index');
            }
            return;
        }
        
        // render error if something fails
        $this->viewPath = 'errors';
        $this->render('invalid_data');
        
    }

    /**
     * Save changes to a user
     * @param $userId
     */
    public function moderator_save() {
        
        // if it is a post, save the new install
        if (!empty($this->data)) {
            if( strlen($this->data['User']['password'])==0 ) {
                unset($this->data['User']['password']);
            }
            
            // try to save the new user data 
            if($this->User->save($this->data)) {
                $this->Session->setFlash(__('user.preferences.aftersave',true));
                $this->redirect('/');
            }
            return;
        }
        
        // render error if something fails
        $this->viewPath = 'errors';
        $this->render('invalid_data');
        
    }
    
    
    /**
     * lets the admin delete a user
     * @param $userId   the id of the user to delete
     */
    public function admin_delete($userId) {

        $this->User->delete($userId, false);
        
        // redirect to summary
        $this->Session->setFlash(__('user.afterdelete',true));
        $this->redirect('index');
    }    

    public function moderator_preferences(){
        
        $this->data = $this->getUser();
        
    }
    
}
?>