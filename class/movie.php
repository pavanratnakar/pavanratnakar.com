<?php
define("API_KEY",'40677518dfbe84497b9d15dbd9df1464');
include_once ('db.php');
include_once ('functions.php');
include_once ('TMDb.php');
set_time_limit(0);
if(file_exists('cfg/config.cfg.php'))
{
   include_once('cfg/config.cfg.php');
}
else
{
   include_once('../cfg/config.cfg.php');
}
class Movie
{
    public function __construct()
    {
        $db=new DB();
    }
    public function getAllMovies($limit,$tmdbId=0)
    {
        $function=new Functions();
        $limit_query_parameter='';
        if($limit==0)
        {
            $sql=mysql_query("SELECT id,tmdbId,movie_name FROM ".MOVIE_TABLE." WHERE tmdbId NOT IN (".$tmdbId.") ORDER BY movie_name");

        }
        else
        {
            $offset_result = mysql_query("SELECT FLOOR(RAND() * COUNT(*)) AS `offset` FROM ".MOVIE_TABLE." ");
            $offset_row = mysql_fetch_object( $offset_result ); 
            $offset = $offset_row->offset;
            $sql=mysql_query( "SELECT id,tmdbId,movie_name FROM ".MOVIE_TABLE." LIMIT $offset,$limit " );
        }
        for ($i = 0, $numRows = mysql_num_rows($sql); $i < $numRows; $i++) 
        {
            $row = mysql_fetch_assoc($sql);
            $movie_array = array();
            $movie_array['id'] = $row['id'];
            $movie_array['tmdbId'] = $row['tmdbId'];
            $movie_array['movie_name'] = $row['movie_name'];
            $movie_array['images'] = $this->getMovieThumbnails($row['tmdbId'],'thumb');
            $movies[] = $movie_array;
        }
        return $movies;
    }
    public function getSpecificMovies($tmdbId)
    {
        $function=new Functions();
        $sql=mysql_query("SELECT id,tmdbId,movie_name FROM ".MOVIE_TABLE." WHERE tmdbId = ".$tmdbId."");
        for ($i = 0, $numRows = mysql_num_rows($sql); $i < $numRows; $i++) 
        {
            $row = mysql_fetch_assoc($sql);
            $movie_array = array();
            $movie_array['id'] = $row['id'];
            $movie_array['tmdbId'] = $row['tmdbId'];
            $movie_array['movie_name'] = $row['movie_name'];
            $movie_array['images'] = $this->getMovieThumbnails($row['tmdbId'],'thumb');
            $movies[] = $movie_array;
        }
        return $movies[0];
    }
    public function getNextMovie($movieIds)
    {
        $function=new Functions();
        $sql=mysql_query("SELECT id,tmdbId,movie_name FROM ".MOVIE_TABLE." WHERE tmdbId NOT IN (".$movieIds.") LIMIT 2");
        for ($i = 0, $numRows = mysql_num_rows($sql); $i < $numRows; $i++) 
        {
            $row = mysql_fetch_assoc($sql);
            $movie_array = array();
            $movie_array['id'] = $row['id'];
            $movie_array['tmdbId'] = $row['tmdbId'];
            $movie_array['movie_name'] = $row['movie_name'];
            $movie_array['images'] = $this->getMovieThumbnails($row['tmdbId'],'thumb');
            $movies[] = $movie_array;
        }
        return $movies;
    }
    public function getMovieDetails($tmdbId)
    {
        $function=new Functions();
        $tmdbId= $function->dbCheckValues($tmdbId);
        $sql=mysql_query("SELECT id,tmdbId,language,tagline,overview,rating,homepage,trailer,movie_release,movie_name FROM ".MOVIE_TABLE." where tmdbId='$tmdbId'");
        for ($i = 0, $numRows = mysql_num_rows($sql); $i < $numRows; $i++) 
        {
            $row = mysql_fetch_assoc($sql);
            $movie_array = array();
            $language=$row['language'];
            if($language=='en')
            {
                $newLanguage="English";
            }
            $movie_array['status'] = $function->dateBetween(date("Ymd"), $row['movie_release']);
            $movie_array['language'] = $newLanguage;
            $movie_array['tmdbId'] = $tmdbId;
            $movie_array['tagline'] = $row['tagline'];
            $movie_array['overview'] = $row['overview'];
            $movie_array['rating'] = $row['rating'];
            $movie_array['homepage'] = $row['homepage'];
            $movie_array['trailer'] = $row['trailer'];
            $movie_array['release'] = date("D M j Y", strtotime($row['movie_release'])); 
            $movie_array['movie_name'] = $row['movie_name'];
            $movie_array['images'] = $this->getMovieThumbnails($tmdbId,'cover');
            $movie[] = $movie_array;
        }
        return $movie[0];
    }
    public function getMovieThumbnails($tmdbId,$type)
    {
        $function=new Functions();
        $tmdbId= $function->dbCheckValues($tmdbId);
        $movieId= $function->dbCheckValues($movieId);
        $sql=mysql_query("SELECT id,url,image_id,height,width FROM ".MOVIE_IMAGES_TABLE." where tmdbId='$tmdbId' AND image_type='$type'");
        for ($i = 0, $numRows = mysql_num_rows($sql); $i < $numRows; $i++) 
        {
            $row = mysql_fetch_assoc($sql);
            $image_array = array();
            $image_array['id'] = $row['id'];
            $image_array['url'] = $row['url'];
            $image_array['image_id'] = $row['image_id'];
            $image_array['height'] = $row['height'];
            $image_array['width'] = $row['width'];
            $images[] = $image_array;
        }
        return $images;
    }
    public function addMovieToDatabase($tmdbId)
    {
        $function=new Functions();
        $tmdb = new TMDb(API_KEY);
        $movie = $tmdb->getMovie($tmdbId);
        $tmdbId= $function->dbCheckValues($tmdbId);
        $language= $function->dbCheckValues($movie['spoken_languages'][0]['name']);
        $name = $function->dbCheckValues($movie['title']);
        if ($name) {
            $tagline = $function->dbCheckValues($movie['tagline']);
            $overview = $function->dbCheckValues($movie['overview']);
            $rating = $function->dbCheckValues($movie['vote_average']);
            $homepage = $function->dbCheckValues($movie['homepage']);
            $release = $function->dbCheckValues($movie['release_date']);
            $trailers = $tmdb->getMovieTrailers($tmdbId);
            if ($trailers['youtube'] && $trailers['youtube'][0]) {
                $trailer = 'http://www.youtube.com/watch?v='.$trailers['youtube'][0]['source'];
            }
            $sql=mysql_query("SELECT id FROM ".MOVIE_TABLE." WHERE tmdbId='$tmdbId'");
            if(mysql_num_rows($sql)==0)
            {
                $result=mysql_query("INSERT INTO ".MOVIE_TABLE."(tmdbId,language,movie_name,tagline,overview,rating,homepage,trailer,movie_release) VALUES('$tmdbId','$language','$name','$tagline','$overview','$rating','$homepage','$trailer','$release')");
            }
            else
            {
                $result=mysql_query("UPDATE ".MOVIE_TABLE." SET movie_name='$name',tagline='$tagline',overview='$overview',rating='$rating',homepage='$homepage',trailer='$trailer',movie_release='$release',language='$language' WHERE tmdbId='$tmdbId'");
            }
            if($result)
            {
                $this->addImagesToDatabase($tmdbId);
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
    }
    public function addImagesToDatabase($tmdbId)
    {
        $function=new Functions();
        $tmdbId= $function->dbCheckValues($tmdbId);
        $tmdb = new TMDb(API_KEY);
        $json = $tmdb->getMovieImages($tmdbId);
        $response = array();
        if ($json && $json['posters']) {
            foreach($json['posters'] as $image)
            {
                $tmdbId= $function->dbCheckValues($tmdbId);
                $file_path = $function->dbCheckValues($image['file_path']);
                $image_id = $function->dbCheckValues($image['id']);
                $ori_height = $function->dbCheckValues($image['height']);
                $ori_width = $function->dbCheckValues($image['width']);
                $type = 'cover';
                $width = '185';
                $height = ($ori_height * $width) / $ori_width;
                $url = 'http://image.tmdb.org/t/p/w185'.$file_path;
                $sql=mysql_query("SELECT id FROM ".MOVIE_IMAGES_TABLE." WHERE tmdbId='$tmdbId' AND image_id='$image_id' AND image_type='$type'");
                if(mysql_num_rows($sql)==0)
                {
                    $result=mysql_query("INSERT INTO ".MOVIE_IMAGES_TABLE."(tmdbId,image_type,url,image_id,height,width) VALUES('$tmdbId','$type','$url','$image_id','$height','$width')");
                }
                $type = 'thumb';
                $width = '92';
                $url = 'http://image.tmdb.org/t/p/w92'.$file_path;
                $height = ($ori_height * $width) / $ori_width;
                $sql=mysql_query("SELECT id FROM ".MOVIE_IMAGES_TABLE." WHERE tmdbId='$tmdbId' AND image_id='$image_id' AND image_type='$type'");
                if(mysql_num_rows($sql)==0)
                {
                    $result=mysql_query("INSERT INTO ".MOVIE_IMAGES_TABLE."(tmdbId,image_type,url,image_id,height,width) VALUES('$tmdbId','$type','$url','$image_id','$height','$width')");
                }
            }
        }
        if($result)
            return TRUE;
        else
            return FALSE;
    }
    public function showImages()
    {
    
    
    
    }
    public function getPageSpecificMovies($movieId)
    {
        if($movieId)
        {
            $function=new Functions();
            $movieIDParameter=$function->checkValues($movieId);
            $movies=$this->getAllMovies(MOVIE_LIMIT,$movieIDParameter);
            shuffle($movies);
            $parameterMovie=$this->getSpecificMovies($movieIDParameter);
            if($parameterMovie)
            {
                array_unshift($movies, $parameterMovie);
            }
        }
        else
        {
            $movies=$this->getAllMovies(MOVIE_LIMIT);
            shuffle($movies);
        }
        return $movies;
    }
    public function getAllMoviesByMovieName($movieName)
    {
        $function=new Functions();
        $sql=mysql_query("SELECT id,tmdbId,movie_name FROM ".MOVIE_TABLE." WHERE movie_name LIKE '%".$movieName."%'");
        for ($i = 0, $numRows = mysql_num_rows($sql); $i < $numRows; $i++) 
        {
            $row = mysql_fetch_assoc($sql);
            $movie_array = array();
            $movie_array['id'] = $row['id'];
            $movie_array['tmdbId'] = $row['tmdbId'];
            $movie_array['movie_name'] = $row['movie_name'];
            $movies[] = $movie_array;
        }
        return $movies;
    }
}
?>