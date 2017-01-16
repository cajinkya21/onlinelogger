<?php
/*
Template Name: curriculum
*/
session_start();
require_once 'sqlSettings.php';

?>
<?php do_action( '__before_main_wrapper' ); ##hook of the header with get_header ?>
<div id="main-wrapper" class="<?php echo implode(' ', apply_filters( 'tc_main_wrapper_classes' , array('container') ) ) ?>">

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
                                    <article <?php tc__f('__article_selectors') ?>>
                                        <?php do_action( '__loop' ); ?>
                                    </article>
                                <?php do_action ('__after_article') ?>
                            <?php endwhile; ?>

       <center>
                            <?php
                            if(!$_POST["combo"] and !$_POST["btn"]){
                              echo "  <H4> Please select the subject</H4>";
                            }
                            else {
                                echo "<H4> Selected subject is ".$_POST["combo"]."</H4>";
                                $_SESSION["subjectName"] = $_POST["combo"];
                            }
                            ?>
                            </center>
<?php


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
    if(!$_POST["combo"] and !$_POST["btn"]){
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
    if($_POST["combo"] and !$_POST["btn"]){
        $sub=$_POST["combo"];
        $sub=trim($sub);
        
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








                        <?php endif; ##end if have posts ?>

                    <?php do_action ('__after_loop');##hook of the comments and the posts navigation with priorities 10 and 20 ?>

                </div><!--.article-container -->

           <?php do_action( '__after_article_container'); ##hook of left sidebar ?>

        </div><!--.row -->
    </div><!-- .container role: main -->

    <?php do_action( '__after_main_container' ); ?>

</div><!-- //#main-wrapper -->

<?php do_action( '__after_main_wrapper' );##hook of the footer with get_footer ?>
