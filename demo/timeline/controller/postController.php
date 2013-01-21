<?php
class postController
{
    public function __construct($ref=null)
    {
		include_once ('../class/config.php');
		include_once ('../class/utils.php');
		include_once ('../class/post.php');
		$this->utils=new Utils();
		$this->post=new Post();
		$this->$ref();
    }
    public function getPosts(){
        $response = $_GET["jsoncallback"] . "(" . json_encode($this->post->getPosts()) . ")";
        echo $response;
        unset($response);
    }
    public function operation()
    {
        $oper=$this->utils->checkValues($_REQUEST['oper']);
        /* ADD */
		if($oper=='add')
		{
			$response=$this->post->addDetails(
				$this->utils->checkValues($_POST['post_message'])
				);
			if($response)
			{
				$status=TRUE;
				$message="Details Added";
			}
			else
			{
				$status=FALSE;
				$message="Details could not be added";
			}
		}
		/* ADD */
		/* DELETE */
		else if($oper=='del')
		{
			$response=$this->post->deleteDetails(
                $this->utils->checkValues($_POST['id'])
            );
			if($response)
			{
				$status=TRUE;
				$message="Details Deleted";
			}
			else
			{
				$status=FALSE;
				$message="Sorry ! Details could not be deleted. You dont have the right permissions to delete.";
			}
		}
		/* DELETE */
		$returnArray= array(
			"status" => $status,
			"message" => $message
		);
		$response = $_POST["jsoncallback"] . "(" . json_encode($returnArray) . ")";
		echo $response;
		unset($response);
    }
}
if(isset($_REQUEST['ref']))
{
    $postController=new PostController($_REQUEST['ref']);
}
?>