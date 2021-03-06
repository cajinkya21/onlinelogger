<?php
/*
Template Name: Admin home page
*/
session_start();
require_once 'sqlSettings.php';
$active = 0;

?>

<?php do_action( '__before_main_wrapper' ); ##hook of the header with get_header ?>
<div id="main-wrapper" class="<?php echo implode(' ', apply_filters( 'tc_main_wrapper_classes' , array('container') ) ) ?>">
<?php echo "Welcome ".$_SESSION["uname"]. " <form action = \"http://localhost/onlineLog/\"> <input type = \"submit\" value = \"Logout\" ></form>";?>
    <?php do_action( '__before_main_container' ); ##hook of the featured page (priority 10) and breadcrumb (priority 20)...and whatever you need! ?>

    <div class="container" role="main">
        <div class="<?php echo implode(' ', apply_filters( 'tc_column_content_wrapper_classes' , array('row' ,'column-content-wrapper') ) ) ?>">

            <?php do_action( '__before_article_container'); ##hook of left sidebar?>

                <div id="content" class="<?php echo implode(' ', apply_filters( 'tc_article_container_class' , array( TC_utils::tc_get_layout( TC_utils::tc_id() , 'class' ) , 'article-container' ) ) ) ?>">

                    <?php do_action ('__before_loop');##hooks the heading of the list of post : archive, search... ?>

                        <?php if ( tc__f('__is_no_results') || is_404() ) : ##no search results or 404 cases ?>
                           
                                <article <?php tc__f('__article_selectors') ?>>
                                    <?php do_action( '__loop' ); ?>
                                </article>
                          
                        <?php endif; ?>
                           <?php if ( have_posts() && ! is_404() ) : ?>
                            <?php while ( have_posts() ) : ##all other cases for single and lists: post, custom post type, page, archives, search, 404 ?>
                                <?php the_post(); ?>

                                <?php do_action ('__before_article') ?>
                                    <center>
                                        <article <?php tc__f('__article_selectors') ?>>
                                            <?php do_action( '__loop' ); ?>
                                        </article>
                                    </center>
                                <?php do_action ('__after_article') ?>

                            <?php endwhile; ?>
                            <center>
                            <?php
                            if(!$_POST["combo"] and !$_POST["actn"] and !$_SESSION["workon"]){
                              echo "  <H3> Please select the subject</H3>";
                            }
                            else {
                            	if(!$_POST["actn"] and !$_SESSION["workon"]){
                             	    echo "<H4> Selected subject is ".$_POST["combo"]."</H4>";
                               		$_SESSION["subjectName"] = $_POST["combo"];
                               	}
                            }	
                            ?>
                            </center>
<?php

//Here You can add a new entry into the database!

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
try{
    $query = "SELECT * FROM olSubTable";
    $result =mysqli_query($conn,$query);

    $storeArray = Array();
    while($row = mysqli_fetch_assoc($result)){
        $storeArray[] =  $row["subName"];
    }
}
catch(Exception $e){
//  echo $e;//remove comment to see the error <for administrator>.
    echo "error!, please contact administrator!";
}
?>


<center>
<form action = "#" method = "POST">
<?php
    if(!$_POST["combo"] and !$_POST["actn"] and !$_SESSION["workon"]){
        echo "<select name = \"combo\">";

        foreach ($storeArray as $subname){
          echo "<option>".$subname."</option>";
        }
        echo "</select> <br/><br/> <input type = \"submit\" value = \"show curriculum\"> ";

    }
?>
</form>
</center>
<form action = "#" method = "post">
<?php
	echo "<input type = \"hidden\" name = \"btn\" value = \"hmm\">";
	$num = 1;
	$val = 1;
    if($_POST["combo"] and !$_POST["actn"] and !$_SESSION["workon"]){
        $sub=$_POST["combo"];
        $sub=trim($sub);
  		$active = 1;
  		$query = "SELECT * FROM olCurrdb where tsSubject = '$sub' and tsType = 'Topic'";
		$result = mysqli_query($conn,$query);
		$storeArray = Array();
		while($row = mysqli_fetch_assoc($result)){
	    	$storeArray[] =  $row["tsName"];
		}

		foreach ($storeArray as $wow){
 			echo "<h4>".$num.")".$wow."</h4>";
 				$query = "SELECT * FROM olCurrdb where tsSubject = '$sub' and tsType = 'Subtopic' and tsTopic = '$wow'";
				$result = mysqli_query($conn,$query);
				$arr = Array();
				while($row = mysqli_fetch_assoc($result)){
			    	$arr[] =  $row["tsName"];
				}
				foreach ($arr as $data){
 					echo "<h5>&nbsp;&nbsp;&nbsp;".$val.")".$data."</h5>";
 					$val += 1;
				}
			$num += 1;
	    }
	}
?>

</form>

<?php
if($_SESSION["workon"] == 1){
	$todo = $_SESSION["work"];
	if(strcmp($todo, "Add a Subject") == 0 ){
		$subnm=$_POST["subname"];
		$sql = "INSERT INTO olSubTable (subName) VALUES ('$subnm')";
			if ($conn->query($sql) === TRUE) {
				echo "subject created successfully";
				session_destroy();
				} 
			else {
 				echo "Error: " . $sql . "<br>" . $conn->error;
			}
	}
	elseif(strcmp($todo, "Add a Topic") == 0){
		$topicnm = $_POST["topicname"];
		$topicdt = $_POST["topicdate"];
		$type = $_POST["topictype"];
		$topicsb = $_POST["topicsub"];


		$sql = "INSERT INTO olCurrdb (tsName, tsDate, tsType, tsSubject) VALUES ('$topicnm','$topicdt','$type','$topicsb')";
			if ($conn->query($sql) === TRUE) {
				echo "Topic created successfully";
				session_destroy();
				} 
			else {
 				echo "Error: " . $sql . "<br>" . $conn->error;
			}
	}
	elseif(strcmp($todo, "Add a Subtopic") == 0){
		$subtopicnm = $_POST["subtopicname"];
		$sbtpdt = $_POST["subtopicdate"];
		$type = $_POST["subtopictype"];
		$subsub = $_POST["subtopicsub"];
		$subtpk = $_POST["subtopic"];


		$sql = "INSERT INTO olCurrdb (tsName, tsDate, tsType, tsSubject, tsTopic) VALUES ('$subtopicnm', '$sbtpdt', '$type', '$subsub', '$subtpk')";
			if ($conn->query($sql) === TRUE) {
				echo "Subtopic created successfully";
				session_destroy();
				} 
			else {
 				echo "Error: " . $sql . "<br>" . $conn->error;
			}

	}
	elseif(strcmp($todo, "Add a Lab Subject") == 0){
		$subnm = $_POST["labsubname"];
		$sql = "INSERT INTO olLabSubTable (labSubName) VALUES ('$subnm')";
			if ($conn->query($sql) === TRUE) {
				echo "Lab subject created successfully";
				session_destroy();
				} 
			else {
 				echo "Error: " . $sql . "<br>" . $conn->error;
			}
	
	}

	else{
		$lbnm = $_POST["labtopicname"];
		$lbdt = $_POST["labtopicdate"];
		$lbsb = $_POST["labtopicsub"];
		$sql = "INSERT INTO olLabTable (labAssignName, labAssignDate, labAssignSub) VALUES ('$lbnm', '$lbdt', '$lbsb')";
		if ($conn->query($sql) === TRUE) {
				echo "Lab subject created successfully";
				session_destroy();
				} 
			else {
 				echo "Error: " . $sql . "<br>" . $conn->error;
			}
	}


	session_destroy();
}
?>


<form action = "#" method = "post">
<?php
if($active == 0 and !$_SESSION["workon"]){
	if(!$_POST["actn"]){
		echo "<center>	<form action = \"#\" method = \"POST\">	<br/>	<br/>	<h3>Please select the operation.</h3>	<select name = \"actn\">	<option>Add a Subject</option>	<option>Add a Topic</option>	<option>Add a Subtopic</option>		<option>Add a Lab Subject</option>		<option>Add a Lab Assignment</option>	</select>	<br/>	<input type = \"submit\" value = \"select\">	</form>	</center>";
	}
	else{
		$todo = $_POST["actn"];
		$_SESSION["workon"] = 1;
		$_SESSION["work"]=$todo;
		if(strcmp($todo, "Add a Subject") == 0 ){
?>
		Name of subject :- <input type = "text" name = "subname">
		<br/>
	<center>	<input type = "submit" value = "Lets create this subject!!"></center>
<?php

		}
		elseif(strcmp($todo, "Add a Topic") == 0){
?>
		Name of Topic 				:- <br/><input type = "text" name = "topicname"><br/>
		Date          				:- <br/><input type = "text" name = "topicdate"><br/>
		<input type = "hidden" name = "topictype" value = "Topic">
		Subject to which it belongs :- <br/><input type = "text" name = "topicsub">
	<br/>
	<center>	<input type = "submit" value = "Lets create this Topic!!"></center>

<?php
		}
		elseif(strcmp($todo, "Add a Subtopic") == 0){

?>
		Name of SubTopic 			:- <br/><input type = "text" name = "subtopicname"><br/>
		Date          				:- <br/><input type = "text" name = "subtopicdate"><br/>
		<input type = "hidden" name = "subtopictype" value = "Subtopic">
		Subject to which it belongs :- <br/><input type = "text" name = "subtopicsub"><br/>
		Topic to which it belongs 	:- <br/><input type = "text" name = "subtopic">
			<br/>
	<center>	<input type = "submit" value = "Lets create this Subtopic!!"></center>
<?php
		}

		elseif(strcmp($todo, "Add a Lab Subject") == 0){

?>
			Name of Lab subject :- <input type = "text" name = "labsubname">
			<br/>
			<center> <input type = "submit" value = "Lets create this Lab subject!!"></center>

<?php
		}

		else{
?>
			Name of Lab Assignment 				:- <br/><input type = "text" name = "labtopicname"><br/>
			Date          				:- <br/><input type = "text" name = "labtopicdate"><br/>
			Lab Subject to which it belongs :- <br/><input type = "text" name = "labtopicsub">
			<br/>
			<center>	<input type = "submit" value = "Lets create this Lab Assignment!!"></center>
<?php

		}

	}
}


?>
</form>

	

                        <?php endif; ##end if have posts ?>

                    <?php do_action ('__after_loop');##hook of the comments and the posts navigation with priorities 10 and 20 ?>

                </div><!--.article-container -->

           <?php do_action( '__after_article_container'); ##hook of left sidebar ?>

        </div><!--.row -->
    </div><!-- .container role: main -->

    <?php do_action( '__after_main_container' ); ?>

</div><!-- //#main-wrapper -->

<?php do_action( '__after_main_wrapper' );##hook of the footer with get_footer ?>
