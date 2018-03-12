<?php 
$conn = mysqli_connect('127.0.0.1', 'root', '', 'inspirations');
// connect to database
// lets assume a user is logged in with id $user_id
$user = new User();
if($user->isLoggedIn()){
$user_id = $user->data()->id;
} else{
    $user_id = 0;
    
}
if (!$conn) {
  die("Error connecting to database: " . mysqli_connect_error($conn));
  exit();
}
// if user clicks like or dislike button
if (isset($_POST['action'])) {
  $post_id = $_POST['post_id'];
  $action = $_POST['action'];
  switch ($action) {
  	case 'like':
         $sql="INSERT INTO vote_info (user_id, idea_id, vote_action) 
         	   VALUES ($user_id, $post_id, 'like') 
         	   ON DUPLICATE KEY UPDATE vote_action ='like'";
         break;
  	case 'dislike':
          $sql="INSERT INTO vote_info (user_id, idea_id, vote_action) 
               VALUES ($user_id, $post_id, 'dislike') 
         	   ON DUPLICATE KEY UPDATE vote_action ='dislike'";
         break;
  	case 'unlike':
	      $sql="DELETE FROM vote_info WHERE user_id=$user_id AND idea_id=$post_id";
	      break;
  	case 'undislike':
      	  $sql="DELETE FROM vote_info WHERE user_id=$user_id AND idea_id=$post_id";
      break;
  	default:
  		break;
  }
  // execute query to effect changes in the database ...
  mysqli_query($conn, $sql);
  echo getRating($post_id);
  exit(0);

}
// Get total number of likes for a particular post
function getLikes($id)
{
  global $conn;
  $sql = "SELECT COUNT(*) FROM vote_info 
  		  WHERE idea_id = $id AND vote_action='like'";
  $rs = mysqli_query($conn, $sql);
  $result = mysqli_fetch_array($rs);
  return $result[0];
}
// Get total number of dislikes for a particular post
function getDislikes($id)
{
  global $conn;
  $sql = "SELECT COUNT(*) FROM vote_info 
  		  WHERE idea_id = $id AND vote_action='dislike'";
  $rs = mysqli_query($conn, $sql);
  $result = mysqli_fetch_array($rs);
  return $result[0];
}

// Get total number of likes and dislikes for a particular post
function getRating($id)
{
  global $conn;
  $rating = array();
  $likes_query = "SELECT COUNT(*) FROM vote_info WHERE idea_id = $id AND vote_action='like'";
  $dislikes_query = "SELECT COUNT(*) FROM vote_info 
		  			WHERE idea_id = $id AND vote_action='dislike'";
  $likes_rs = mysqli_query($conn, $likes_query);
  $dislikes_rs = mysqli_query($conn, $dislikes_query);
  $likes = mysqli_fetch_array($likes_rs);
  $dislikes = mysqli_fetch_array($dislikes_rs);
  $rating = [
  	'likes' => $likes[0],
  	'dislikes' => $dislikes[0]
  ];
  return json_encode($rating);
}

// Check if user already likes post or not
function userLiked($post_id)
{
  global $conn;
  global $user_id;
  $sql = "SELECT * FROM vote_info WHERE user_id=$user_id 
  		  AND idea_id=$post_id AND vote_action='like'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
  	return true;
  }else{
  	return false;
  }
}

// Check if user already dislikes post or not
function userDisliked($post_id)
{
  global $conn;
  global $user_id;
  $sql = "SELECT * FROM vote_info WHERE user_id=$user_id 
  		  AND idea_id=$post_id AND vote_action='dislike'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
  	return true;
  }else{
  	return false;
  }
}
$sql = "SELECT * FROM idea";
$result = mysqli_query($conn, $sql);
// fetch all posts from database
// return them as an associative array called $posts
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>