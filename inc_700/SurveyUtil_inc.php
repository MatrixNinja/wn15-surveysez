<?php
//SurveyUtil_inc.php

class SurveyUtil
{
	public static function responseList($myID)
	{
		$myReturn = '';
		
		# SQL statement
		$sql = "select ResponseID, DateAdded from wn15_responses where surveyID = $myID";
		
		#reference images for pager
		$prev = '<img src="' . VIRTUAL_PATH . 'images/arrow_prev.gif" border="0" />';
		$next = '<img src="' . VIRTUAL_PATH . 'images/arrow_next.gif" border="0" />';

		# Create instance of new 'pager' class
		$myPager = new Pager(10,'',$prev,$next,'');
		$sql = $myPager->loadSQL($sql);  #load SQL, add offset depending on the myPager size above: 1-10, 11-20, etc.

		# connection comes first in mysqli (improved) function
		$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

		if(mysqli_num_rows($result) > 0)
		{#records exist - process
			if($myPager->showTotal()==1){$itemz = "response";}else{$itemz = "responses";}  //deal with plural
			$myReturn .= '<div align="center">We have ' . $myPager->showTotal() . ' ' . $itemz . '!</div>';
			while($row = mysqli_fetch_assoc($result))
			{# process each row
				 $myReturn .= '<div align="center">
							<a href="' . VIRTUAL_PATH . 'surveys/response_view.php?id=' . (int)$row['ResponseID'] . '">' . dbOut($row['DateAdded']) . '</a>';
				 $myReturn .= ' </div>';
			}
			$myReturn .= $myPager->showNAV(); # show paging nav, only if enough records	 
		}else{#no records
			$myReturn .= "<div align=center>There are currently no responses to this survey.</div>";	
		}
		@mysqli_free_result($result);
		
		return $myReturn;
	}
}// END Class SurveyUtil