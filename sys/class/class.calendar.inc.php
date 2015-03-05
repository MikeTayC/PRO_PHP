<?php
/**
* Builds and manipulates an events calendar
*
* PHP version 5
*
* LICENSE: This source file is subject to the MIT License, available
* at http://www.opensource.org/licenses/mit-license.html
*
* @author Jason Lengstorf <jason.lengstorf@ennuidesign.com>
* @copyright 2009 Ennui Design
* @license http://www.opensource.org/licenses/mit-license.html
*/


class Calendar extends DB_Connect
{
	/**
	 * The date from which the calendar should be built
	 * Stored in YYYY-MM-DD HH:MM:SS format
	 * @var string the date to use for the calendar
	 */
	private $_useDate;
	 
	 /**
	  * The month for which the calendar is being built
	  * @var int the year being used
	  */
	private $_m;

	 /**
	  *The year from which the month's start day is selected
	  *@var int the number of days in the month
	  */
	private $_y;
	
	 /**
	  * The number of days in the month being used
	  * @var int the number of days in the month
	  */
	private $_daysInMonth;
	
	 /**
	  * the index of the day of the week the month starts on(0-6)
	  * @var int the day of the week the month starts on
	  */
	 private $_startDay;
	 
	 /**
	  * Creates a database object and stores relevant database
	  *
	  * Upon instantiation, this class accepts a databas bject 
	  * that, if not null, is stored in the object's priate $_db
	  * property. if null,, a new PDO object is created and stored instead.
	  *
	  * Additional info is gathered and stored i this method, 
	  * including the month from which the calendar is to be built,
	  * how any days are insaid month, what day the month starts on, 
	  * and what day it is currently.
	  *
	  * @param object $dbo a database object
	  * @param string $useDate the date to use to build the calendar
	  * @return void
	  */
	public function __construct($dbo=NULL, $useDate=NULL)
	{
		/* Call the parent constructor to check for
		 * a database object
		 */
		parent::__construct($dbo);
		 
		 /*
		  * Gather and store data relevant to the month 
		  */
		if( isset($useDate))
		{
			$this->useDate = $useDate;
		}
		else
		{
			$this->useDate = date('Y-m-d H:i:s');
		}
		
		/*
		 * convert to a timestamp, then determine the month 
		 * and year to use when buidling the calendar
		 */
		 $ts = strtotime($this->_useDate);
		 $this->_m = date('m', $ts);
		 $this->_y = date('Y', $ts);
		 
		 /*
		  * Determine how many days are in the month
		  */
		$this->_daysInMonth= cal_days_in_month(
			CAL_GREGORIAN,
			$this->_m,
			$this->_y
		  );		
		 
		/*
		 * Determine what weekday the month starts on
		 */
		$ts = mktime(0,0,0, $this->_m, 1, $this->_y);
		$this->_startDay = date('w', $ts);
		
		 
	}	
}
?> 