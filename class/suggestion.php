<?php
include_once('db.php');
include_once ('functions.php');
include_once ('user.php');
class Suggestion
{
	private $data = array();
	public function __construct($arr = array())
	{
		$db=new DB();
		if(!empty($arr)){
			// The $arr array is passed only when we manually
			// create an object of this class in ajax.php
			$this->data = $arr;
		}
	}
	public function __get($property){
		// This is a magic method that is called if we
		// access a property that does not exist.
		if(array_key_exists($property,$this->data)){
			return $this->data[$property];
		}
		return NULL;
	}
	public function __toString()
	{
		// This is a magic method which is called when
		// converting the object to string:
		return '
		<li id="s'.$this->id.'">
			<div class="vote '.($this->have_voted ? 'inactive' : 'active').'">
				<span class="up"></span>
				<span class="down"></span>
			</div>
			<div class="text">'.$this->suggestion.'</div>
			<div class="rating">'.(int)$this->rating.'</div>
		</li>';
	}
	public function suggestionFormat($row)
	{
		return '
		<li id="s'.$row[id].'">
			<div class="vote '.($row[have_voted] ? 'inactive' : 'active').'">
				<span class="up"></span>
				<span class="down"></span>
			</div>
			<div class="text">'.$row[suggestion].'</div>
			<div class="rating">'.(int)$row[rating].'</div>
		</li>';
	}
	public function addSuggestion($content)
	{
		$function=new Functions();
		$user=new User();
		$content=$function->dbCheckValues($content);
		$userip = $function->ip_address_to_number($_SERVER['REMOTE_ADDR']);
		$userid=$user->getCurrenUserId();
		if($userid)
		$result=mysql_query("INSERT INTO ".SUGGESTION_TABLE." SET suggestion = '".$content."', ip= '".$userip."', uid= '".$userid."'");
		else
		$result=mysql_query("INSERT INTO ".SUGGESTION_TABLE." SET suggestion = '".$content."', ip= '".$userip."'");
		return array(
			'html'	=> (string)(new Suggestion(array(
				'id'			=>	mysql_insert_id(),
				'suggestion'	=>	$content
			)))
		);
	}
	public function addSuggestionVote($vote,$id)
	{
		$function=new Functions();
		$user=new User();
		$vote=$function->dbCheckValues($vote);
		$id=$function->dbCheckValues($id);
		$sql=mysql_query("SELECT 1 FROM ".SUGGESTION_TABLE." WHERE id = $id");
		if(mysql_num_rows($sql)==1)
		{
			$userip = $function->ip_address_to_number($_SERVER['REMOTE_ADDR']);
			$userid=$user->getCurrenUserId();
			if($userid==FALSE)
			{
				$userid='0';
			}
			$result=mysql_query("INSERT INTO ".SUGGESTION_VOTES_TABLE." (suggestion_id,ip,day,vote,uid) VALUES ($id,$userip,CURRENT_DATE,$vote,".$userid.")");
			if($result)
			{
				$result=mysql_query("UPDATE ".SUGGESTION_TABLE." SET ".($vote == 1 ? 'votes_up = votes_up + 1' : 'votes_down = votes_down + 1').",rating = rating + $vote	WHERE id = $id");
				if($result)
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
		}
		else
		{
			return FALSE;
		}
	}
	public function showAllSuggestion()
	{
		$function=new Functions();
		$userip = $function->ip_address_to_number($_SERVER['REMOTE_ADDR']);
		$sql = mysql_query("SELECT s.*, if (v.ip IS NULL,0,1) AS have_voted	FROM ".SUGGESTION_TABLE." AS s
			LEFT JOIN ".SUGGESTION_VOTES_TABLE." AS v
			ON(
				s.id = v.suggestion_id
				AND v.day = CURRENT_DATE
				AND v.ip = $userip
			)
			ORDER BY s.rating DESC, s.id DESC
		");
		$str = '';
		if($sql)
		{
			$str = '<ul class="suggestions">';
			while($row = mysql_fetch_assoc($sql)){
				$str.= $this->suggestionFormat($row);
			}
			$str .='</ul>';
		}
		return $str;
	}
}
?>