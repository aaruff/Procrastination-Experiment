#!/usr/bin/php
<?php

class Emailer extends mysqli {
	const DBHOST = 'localhost';
	const DBUSER = 'user';
	const DBPASS = 'password'; 
	const DB = 'procrastination';
    const FROM = "From: account@host";
    const SERVER = "ip-address";
	/**
	 * calls parent contructor using arguemnts DBHOST, DBUSER, DBPASS, DB
	 *
	 */
	public function __construct(){
		parent::__construct(self::DBHOST, self::DBUSER, self::DBPASS, self::DB);
    }

    public function send_reminder_emails(){
        $subject_records = $this->get_subjects_with_reminders();

        // eliminate subjects with expired tasks
        foreach($subject_records as $subject_record){
            // get the current time
            $current_date_time = $this->get_current_date_time();

           // Subject Deadlines: set appropriate deadlines 
            if(isset($subject_record['first_subject_set_deadline']) && !empty($subject_record['first_subject_set_deadline'])){
                $first_deadline = strtotime($subject_record['first_subject_set_deadline']);
                $second_deadline = strtotime($subject_record['second_subject_set_deadline']);
                $third_deadline = strtotime($subject_record['third_subject_set_deadline']);
            }else{
                $first_deadline = strtotime($subject_record['first_experimenter_set_deadline']);
                $second_deadline = strtotime($subject_record['second_experimenter_set_deadline']);
                $third_deadline = strtotime($subject_record['third_experimenter_set_deadline']);
            }

            // Game Status: if the subject is still participating in this experiment proceed
            if($current_date_time > $first_deadline && $current_date_time > $second_deadline && $current_date_time > $third_deadline){
                continue;
            }

            // Get the current time, and the subjects reminder notification delivery time  
            $current_time = strtotime(date("h:i:s a", $this->get_current_time()));
            $mail_time = strtotime(date("h:i:s a",strtotime($subject_record['reminder_delivery_time'])));
    	    $current_time_plus_ten = strtotime("+10 minutes", $current_time);

            // Confirm Delivery Time: if within 10 minutes of the reminder notification time proceed
            if($current_time > $mail_time || $mail_time > $current_time_plus_ten){
                continue;
            }


            $to = $subject_record['email'];
            if(empty($to)){
                continue;
            }

            $subject = "Experiment Email Reminder";
            $body = "This is an automated message to remind you of the following due dates:\n".
                "Task 1: ". date("m/d/Y h:i a", $first_deadline) . "\n". 
                "Task 2: ". date("m/d/Y h:i a", $second_deadline) . "\n". 
                "Task 3: ". date("m/d/Y h:i a", $third_deadline) . "\n\n". 
                "To complete this task please login to the experiment at:\n".
                "http://".self::SERVER."/pro/subject/login\n\n".
                "If you have any additional question contact hyndman@mail.smu.edu\n";

            mail($to, $subject, $body, self::FROM);
            $this->set_email_log($subject_record['id'], $current_time);
        }
    }


    /**
     * Return a timestamp of the date and time this function
     * is called.
     *
     * @return timestamp
     */
    private function get_current_date_time(){
        // set the time zone
        date_default_timezone_set("US/Eastern");
        // todays date is... 
        $todays_date = date('m/d/Y h:i a');

        // returns a timestamp
        return strtotime($todays_date);
    }

    /**
     * Return a timestamp of the date and time this function
     * is called.
     *
     * @return timestamp
     */
    private function get_current_time(){
        // set the time zone
        date_default_timezone_set("US/Eastern");
        // current time is... 
        $current_time = date('H:i');

        // returns a timestamp
        return strtotime($current_time);
    }

    /**
     * Retrieve the records of subjects participating in reminder treatments.
     */
    private function get_subjects_with_reminders(){
        $column = '*';
        $where = "enable_reminder_notification='yes' and not game_status='completed'";

        $rows = $this->select('subject', $column, $where);

        if(empty($rows)){
            return array(); 
        }

        return $rows;
    }

	/**
	 * Returns the selection specified by the table. column, and options where
	 * parameters.
	 * @param string $table
	 * @param string $columns
	 * @param string $where
	 */
	public function select($table, $columns, $where = ''){
		$query = sprintf("select %s from %s", $columns, $table);
		
		if(!empty($where)){
			$query .= sprintf(" where %s", $where);
		}
		
        $result = $this->query($query);

        if(empty($result)){
            return array();
        }

        $num_rows = $result->num_rows;
		if(empty($num_rows)){
			return array();
		}

		for($i = 0; $i < $num_rows; ++$i){
			$rows[$i] = $result->fetch_array(MYSQL_ASSOC);
		}
		
		return $rows;
    }

    /**
     * Sets the email log for $subject_id.
     *
     * @param string $subject_id
     * @param string $date_time timestamp
     * @return integer number of rows effected.
     */
    public function set_email_log($subject_id, $date_time){
        $set['subject_id'] = $subject_id;
        $set['date_time'] = date("Y-m-d H:i:s", $date_time);

        return $this->insert('email_log', $set);
    }

    /**
     * Inserts row_values into the database.
     * Note: $row_values must be an array, whereby
     * the keys correspond to the table column name(s),
     * and the value corresponds to to value to be inserted.
     *
     * $row_values('column_name'=>'column_value');
     *
     * @param string $table table name
     * @param array $row_values values to insert
     * @return integer
     */
	public function insert($table, array $row_values){
		if(empty($row_values)){
			return false;
		}
		
		$columns = array_keys($row_values);
		$values = array_values($row_values);

		// escape entries
		foreach($values as $key=>$value){
			$values[$key] = $this->escape_string($value);
		}
		
		$table_columns = "(". implode(", " , $columns).")";
		$column_values = "('".implode("', '", $values)."')";

		
		$query = sprintf("insert into %s %s values %s", $table, $table_columns, $column_values);

		return $this->query($query);
	}
}



$mailer = new Emailer();
$mailer->send_reminder_emails();


