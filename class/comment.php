<?
require_once('db.php');
require_once ('functions.php');
require_once ('user.php');
require_once ('page.php');
require_once ('facebookLogin.php');
class Comment
{
	private $commentId;
	private $user;
	public function __construct($commentId=null)
	{
		$db=new DB();
		$this->user=new User();
		$this->commentId=$commentId;
	}
	public function showComment()
	{
		$commentArray=explode('|',$this->commentId);
		$secondary_category_query=' AND secondary_category IS NULL AND third_category IS NULL ';
		if($commentArray[1])
		{
			$secondary_category_query=" AND secondary_category='".$commentArray[1]."' ";
		}
		if($commentArray[2])
		{
			$secondary_category_query.=" AND third_category='".$commentArray[2]."' ";
		}
		$sql = mysql_query("SELECT * FROM ".COMMENTS_TABLE." where category ='".$commentArray[0]."'".$secondary_category_query." ORDER BY id ASC");
		// Selecting all the comments ordered by id in ascending order
		$comments=array();
		while($row=mysql_fetch_assoc($sql))
		{
			if($row['parent']==0)
				// If the comment is not a reply to a previous comment, put it into $comments directly
				$comments[$row['id']] = $row;
			else
			{
				if(!$comments[$row['parent']]) continue;
				$comments[$row['parent']]['replies'][] = $row;
				// If it is a reply, put it in the 'replies' property of its parent
			}
			$js_history.='addHistory({id:"'.$row['id'].'"});'.PHP_EOL;
			// Adds JS history for each comment
		}
		return $comments;
	}
	public function javascriptPrint()
	{
		$commentArray=explode('|',$this->commentId);
		$secondary_category_query=' AND secondary_category IS NULL AND third_category IS NULL ';
		if($commentArray[1])
		{
			$secondary_category_query=" AND secondary_category='".$commentArray[1]."' ";
		}
		if($commentArray[2])
		{
			$secondary_category_query.=" AND third_category='".$commentArray[2]."' ";
		}
		$sql = mysql_query("SELECT * FROM ".COMMENTS_TABLE." where category ='".$commentArray[0]."'".$secondary_category_query." ORDER BY id ASC");
		// Selecting all the comments ordered by id in ascending order
		$comments=array();
		$js_history='';
		while($row=mysql_fetch_assoc($sql))
		{
			if($row['parent']==0)
				// If the comment is not a reply to a previous comment, put it into $comments directly
				$comments[$row['id']] = $row;
			else
			{
				if(!$comments[$row['parent']]) continue;
				$comments[$row['parent']]['replies'][] = $row;
				// If it is a reply, put it in the 'replies' property of its parent
			}
			
			$js_history.='addHistory({id:"'.$row['id'].'"});'.PHP_EOL;
			// Adds JS history for each comment
		}
		$js_history='<div id="commentScript"><script type="text/javascript">
		'.$js_history.'
		</script></div>';
		return $js_history;
	}
	public function formatComment($arr)
	{
		$function=new Functions();
		$user=new User();
		$userid=$user->getCurrenUserId();
		$comment='
		   <div id="com-'.$arr['id'].'" class="waveComment com-'.$arr['id'].'">
				<div class="comment">
					<div class="waveTime">'.$function->waveTime($arr['dt']).'</div>
					<div class="commentAvatar">
						'.$user->getProfilePic($arr['uid']).'
					</div>
					<div class="commentText">
						<span class="name">'.$user->fullName($arr['uid']).':</span> '.$function->urlConverter($arr['comment']).'
					</div>';
		if($userid==$arr['uid'])
		{
			$comment.='
						<div id="deleteLink-'.$arr['id'].'" class="deleteLink commentOptionLink">
							<a href="javascript:void(0);">delete this comment</a><span class="blue">&raquo;</span>
						</div>';
		}
		if($userid)
		{
			if($arr['parent']==0)
			{
				$comment.='	<div class="replyLink commentOptionLink">
								<a href="javascript:void(0);" onclick="addComment(\''.$user->getCurrentUserProfilePic($userid).'\',this,'.$arr['id'].');return false;">add a reply</a> <span class="blue">&raquo;</span>';
				if($userid==$arr['uid'])
				{
					$comment.='&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;&nbsp;</div>';
				}
				else
				{
					$comment.='</div>';
				}
			}
		}
		$comment.='<div class="clear"></div>
			</div>';
		// Output the comment, and its replies, if any
		if($arr['replies'])
		{
			foreach($arr['replies'] as $r)
				$comment.=$this->formatComment($r);
		}
		$comment.='</div>';
		return $comment;
	}
	public function formatFooterComment($arr)
	{
		$function=new Functions();
		$page=new Page();
		$pageDetails=$page->pageDetails();
		$user=new User();
		$comment='<li><i class="imageButton left"></i><div id="comment-'.$arr['dt'].'" class="postContainer">
			'.$user->fullName($arr['uid']).' posted '.$arr['comment'].'<div class="postTime">'.$function->waveTime($arr['dt']).'</div><a target="_blank" href="http://www.pavanratnakar.com/'.$pageDetails[$arr['category']]['link'].'" class="button">read</a>
		</div></li>';
		return $comment;
	}
	public function commentArray($result)
	{
		$function=new Functions();
		$page=new Page('../xml/page.xml');
		$pageDetails=$page->getPageDetails();
		$user=new User();
		$x=0;
		foreach($result as $c)
		{
			$link=$pageDetails[$c['category']+1]['link'];
			if($c['secondary_category'])
			{
				$link.='/'.$c['secondary_category'];
			}
			if($c['third_category'])
			{
				$link.='/'.$c['third_category'];
			}
			$link.='';
			$comment_array[$x] = array(
			"id" => $c['id'],
			"name" => $user->fullName($c['uid']),
			"content" => $c['comment'],
			"link" =>$link,
			"pubDate" => $function->waveTime($c['dt'])
			);
			$x++;			
		}
		return $comment_array;
	}
	public function addComment($comment,$addon,$parent,$category)
	{
		$function=new Functions();
		$user=new User();
		$comment=$function->dbCheckValues($comment);
		$addon=$function->dbCheckValues($addon);
		$category=$function->dbCheckValues($category);
		$categoryArray=explode('|',$category);
		$secondary_category_query=' AND secondary_category IS NULL AND third_category IS NULL ';
		$secondary_category_insert_query='';
		if($categoryArray[1])
		{
			$secondary_category_query=" AND secondary_category='".$categoryArray[1]."' ";
			$secondary_category_insert_query=", secondary_category=".$categoryArray[1]."";
		}
		if($categoryArray[2])
		{
			$secondary_category_query.=" AND third_category='".$categoryArray[2]."' ";
			$secondary_category_insert_query.=", third_category=".$categoryArray[2]."";
		}
		$userip = $function->ip_address_to_number($_SERVER['REMOTE_ADDR']);
		$userid=$user->getCurrenUserId();
		$result=mysql_query("INSERT INTO ".COMMENTS_TABLE." SET uid='".$userid."', category='".$categoryArray[0]."',comment='".$comment."',parent='".$parent."', ip='".$userip."'".$secondary_category_insert_query.", dt=NOW()".$addon);
		if($result)
		{
			/*$id=mysql_insert_id();*/
			$sql=mysql_query("SELECT * FROM ".COMMENTS_TABLE." where uid='".$userid."' and parent='".$parent."' and category='".$categoryArray[0]."' ".$secondary_category_query." order by id desc limit 1");
			$comments=array();
			while($row=mysql_fetch_assoc($sql))
			{
				// If the comment is not a reply to a previous comment, put it into $comments directly
				$comments[$row['id']] = $row;
				$id=$row['id'];
			}
			foreach($comments as $c)
			{
				$return_value=$this->formatComment($c);
			}
			//$commentDetails = mysql_fetch_assoc($sql);
			$userDetailsArray= array(
				"id" => $id,
				"comment" => $return_value
			);
			return $userDetailsArray;
		}
		else
		{
			return FALSE;
		}
	}
	public function deleteComment($commentId)
	{
		$function=new Functions();
		$user=new User();
		$commentId=$function->dbCheckValues($commentId);
		$userid=$user->getCurrenUserId();
		$result=mysql_query("DELETE FROM ".COMMENTS_TABLE." WHERE uid='".$userid."' and id='".$commentId."'");
		if($result)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	public function getLastComments()
	{
		$sql = mysql_query("SELECT * FROM ".COMMENTS_TABLE." ORDER BY id DESC limit 3");
		// Selecting all the comments ordered by id in ascending order
		$comments=array();
		while($row=mysql_fetch_assoc($sql))
		{
			$comments[$row['id']] = $row;
		}
		return $comments;
	}
	public function printComment($commentId)
	{
		$this->commentId=$commentId;
		$comments=$this->showComment();
		$user=new User();
		$returnString='<div class="clear"></div>
		<!-- COMMENT SYSTEM -->
			<div id="wave" class="wave-'.$commentId.'">
				<div id="topBar"><h3>POST COMMENTS</h3></div>
				<div id="sliderContainer">
					<div id="slider"></div>
					<div class="clear"></div>
				</div>
				<div id="commentArea">';
				if(sizeof($comments)==0)
				{
					$returnString.='<div id="noComment" class="comment">
						No Comments Posted yet. Be the first one to comment.
					</div>';
				}
				else
				{
					foreach($comments as $c)
					{
						$returnString.=$this->formatComment($c);
					}
				}
				$returnString.='</div>';
				$check=$this->user->checkLoginType();
				$userid=$this->user->getCurrenUserId();
				if($check==TRUE)
				{
					$returnString.='<input type="button" id="button-'.$userid.'" class="waveButtonMain waveCommentButton1" value="Add a comment" onclick="addComment(\''.$this->user->getCurrentUserProfilePic($userid).'\')" />';
				}
				else
				{
					$returnString.='<a href="javascript:void(0);" class="open loginToComment" id="openSlide">Login to comment</a>';
				}
				$returnString.='<div id="bottomBar"></div>
			</div>
		<!-- COMMENT SYSTEM -->';
		return $returnString;
	}
}
?>