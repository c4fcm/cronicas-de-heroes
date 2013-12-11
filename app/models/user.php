<?php
class User extends AppModel {

    var $name = 'User';
	
    var $displayField = 'username';

    var $actsAs = array('Containable');
    
    var $validate = array(
		'username' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	/**
	 * Set some defaults before saving a new user
	 */
    function beforeSave() {
    	// default to NOT admin
    	if(!isset($this->data['User']['admin'])){
    		$this->data['User']['admin'] = 0;
    	}
    	// encrypt the password if there is one
        if(isset($this->data['User']['password'])){
            $this->data['User']['password'] = md5($this->data['User']['password']);
        }
        return true; 
    }
    
    /**
     * Check username and password, returning the user if they are correct, and
     * false if they are not.
     * @param $data
     */
    function verifyLogin($data) {
        $user = $this->findByUsernameAndPassword(
                    $data['User']['username'],
                    md5($data['User']['password']) 
        );

        if (!empty($user)) {
            return $user;
        } else {
            $this->invalidate('', 'Invalid login, please try again');
        }
        
        return false;
    }
    
    function isAdmin($user){
        return ($user['User']['admin']==1);        
    }
    
}
?>