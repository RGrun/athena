<?php

	#Notification.php
	
	include_once "Gremlin.php";
	
	class Notification {
	
		/******************************************************
		not_id - Title              	- item  - behavior
		+-- ---------------------------------------------------
		+--  1      - Loan Request       - req   - resolved  -
		+--  2      - Loan Reply         - req   - dismiss   -
		+--  3  *    - Tray Picked up     - tray  - dismiss   -
		+--  4 xxx   - Case Reminder      - case  - expired   -
		+--  5      - Tray Relinquished  - tray  - resolved  -
		+--  6  *    - Tray Unassigned    - tray  - resolved  -
		+--  7  *    - New Case Created   - case  - dismiss   -
		+--  8      - Tray Late          - tray  - resolved  -
		*******************************************************/
		
	
		#these constants are for notifications
		public static $_LOAN_REQUEST = 1;
		public static $_LOAN_REPLY = 2;
		public static $_TRAY_PICKED_UP = 3;
		public static $_CASE_REMINDER = 4;
		public static $_TRAY_RELINQUISHED = 5;
		public static $_TRAY_UNASSIGNED = 6;
		public static $_NEW_CASE_CREATED = 7;
		public static $_TRAY_LATE = 8;
			  
		public static $_REQUEST = 1;
		public static $_TRAY = 2;
		public static $_CASE = 3;
			 
			 
		private $gremlin;
		
		public $notificationID;
		public $userID;
		public $notType; #Must be set to one of the eight static constants above
		public $itemID; #Must be set to one of the three static constants above
		public $hidden; #Set to 1 if notification should not be seen anymore
		public $msg;
		public $dttm; #Time the notification was generated
		public $evDTTM; #Time of event related to the notification
		public $vwDTTM; #Last time when the notification was seen
		
		
		public function __construct($notificationID) {
		
			$this->gremlin = new Gremlin();
			
			#load notification's info from ID
			$sql = "SELECT * FROM unotifs WHERE un_id='$notificationID'";
			
			$rawData = $gremlin->query($sql);
			
			extract($rawData);
			
			$this->notificationID = $notificationID;
			$this->notType = $not_id;
			$this->itemID = $item_id;
			$this->hidden = $hidden;
			$this->msg = $msg;
			$this->dttm = $dttm;
			$this->evDTTM = $evdttm;
			$this->vwDTTM = $vwdttm;
		
		
		
		}
	
		function __destruct() {
		    $gremlin->closeConnection();
		}
	
	
	}
	
	
?>