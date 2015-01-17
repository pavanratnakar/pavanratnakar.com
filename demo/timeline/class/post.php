<?php
class Post
{
    private $mysqli;
    private $utils;
    private $table;
    private $id='post_id';
    public function __construct()
    {
        $this->mysqli=new mysqli(Config::$db_server,Config::$db_username,Config::$db_password,Config::$db_database);
        $this->utils=new Utils();
        $this->table=Config::$demo_timeline;
    }
    public function getPosts()
    {
        if ($result = $this->mysqli->query("SELECT COUNT(*) AS count FROM ".$this->table." WHERE delete_flag=0 ORDER BY post_date"))
        {
            while ($row = $result->fetch_object())
            {
                $i=0;
                $count = $row->count;
                if( $count >0 ) {
                    $query="SELECT post_id, post_message, post_date FROM  ".$this->table." WHERE delete_flag=0 ORDER BY post_date";
                    if ($result1 = $this->mysqli->query($query)) {
                        while ($row1 = $result1->fetch_object()) {
                            $responce->rows[$i]=array(
                                'post_id'=>$row1->post_id,
                                'post_message'=>$row1->post_message,
                                'post_data'=>$row1->post_date
                            );
                            $i++;
                        }
                        return $responce;
                    }
                }
            }
        }
    }
    public function addDetails($post_message)
    {
        $post_message=$this->mysqli->real_escape_string($post_message);
        $this->user_ip = $this->utils->ip_address_to_number($_SERVER['REMOTE_ADDR']);
        if ($result = $this->mysqli->query("INSERT INTO ".$this->table."(post_message,user_ip) VALUES('$post_message','".$this->user_ip."')")) {
            if($this->mysqli->affected_rows>0) {
                return TRUE;
            }
        }
        return FALSE;
    }
    public function deleteDetails($id)
    {
        $id=$this->mysqli->real_escape_string($id);
        if ($result = $this->mysqli->query("UPDATE ".$this->table." SET delete_flag=TRUE WHERE ".$this->id."='".$id."' AND not_delete=0")) {
            if($this->mysqli->affected_rows>0) {
                return TRUE;
            }
        }
        return FALSE;
    }
    public function __destruct()
    {
        $this->mysqli->close();
    }
}
?>