<?php
	class User extends AppModel {
		var $name = 'User';
		public function GetCurrentUser($user){
			return $this->find('first',array('conditions'=>array('username'=>$user)));
		}
	}