<?php
/**
 * survey_view.php works with survey_list.php to create a list/view app.
 *
 * demo_list_pager.php along with demo_view_pager.php provides a sample web application
 *
 * The difference between demo_list.php and demo_list_pager.php is the reference to the 
 * Pager class which processes a mysqli SQL statement and spans records across multiple  
 * pages. 
 *
 * The associated view page, demo_view_pager.php is virtually identical to demo_view.php. 
 * The only difference is the pager version links to the list pager version to create a 
 * separate application from the original list/view. 
 * 
 * @package nmPager
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 3.02 2011/05/18
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see demo_list_pager.php
 * @see survey_list.php
 * @see index.php
 * @see Pager_inc.php 
 * @todo Create survey_view.php page
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
 
# check variable of item passed in - if invalid data, forcibly redirect back to survey_list.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "surveys/index.php");
}

$mySurvey = new Survey($myID);
#dumpDie is a custom code for vardump and die
//dumpDie($mySurvey);

if($mySurvey->isValid)
{
	$config->titleTag = $mySurvey->Title . " survey!";
}else{//no survey
	$config->titleTag = "There's no survey.";
}

get_header(); #defaults to theme header or header_inc.php
echo '<h3 align="center">' . $config->titleTag . '</h3>';

if($mySurvey->isValid)
{
	echo "<b>" . $mySurvey->SurveyID . ") </b>";
	echo "<b>" . $mySurvey->Title . "</b>-->";
	echo "<b>" . $mySurvey->Description . "</b><br />";
	echo $mySurvey->showQuestions();
	echo SurveyUtil::responseList($myID);
	
}else{//no survey
	echo '<p>Please check to see if there is a problem.</p>';
}	
get_footer(); #defaults to theme footer or footer_inc.php

//This file is related to Survey_inc.php