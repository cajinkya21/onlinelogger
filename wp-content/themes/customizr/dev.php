<?php
/*
Template Name: developer
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
<center>
                                <?php do_action ('__before_article') ?>
                                    <article <?php tc__f('__article_selectors') ?>>
                                        <?php do_action( '__loop' ); ?>
                                    </article>
                                <?php do_action ('__after_article') ?>
</center>
                            <?php endwhile; ?>

                            <div>
                            	<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hello Everyone, Its Tushar Sandeep Agey here! From SY IT. I have developed this website in order to decrease the stress of remembering the curriculum and the topics that are taught in the class on daily basis.
                            	<center><img src = "http://localhost/onlineLog/wp-content/uploads/2016/06/tush.jpg" width = 400 height = 400></img></center>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Special Thanks to all my friends and my family who supported me in the development of this website. Thank you everyone. If you have something to suggest, you can always send me an email at ageyts15.it@coep.ac.in.
                            	</h3>
                            </div>
<br/><br/>
                            <div>
                            	<form action "#" method = "post">
                            		<center><h3>Feedback form:-</h3>
                            		Name :- <br/><input type = "text" name = "uname"><br/>
                            		email:- <br/><input type = "text" name = "umail"><br/>
                            		Message:-<br/><textarea rows = 10 cols = 40 name = "umsg"></textarea><br/>
                            		<input type = "submit" value = "Send"></center>
                            	</form>

                            </div>
                            <?php
                            	if($_POST["uname"]){
                            		$nm = $_POST["uname"];
                            		$ml = $_POST["umail"];
                            		$msg = $_POST["umsg"];
                            		$conn = new mysqli($servername, $username, $password, $dbname);
									// Check connection
									if ($conn->connect_error) {
									    die("Connection failed: " . $conn->connect_error);
									}
									$sql = "INSERT INTO olFeedbackTable (fbkName, fbkEmail, fbkMsg) VALUES ('$nm', '$ml', '$msg')";
									if ($conn->query($sql) === TRUE) {
										echo "<center>Message sent successfully</center>";
										session_destroy();
										} 
									else {
						 				echo "Error: " . $sql . "<br>" . $conn->error;
									}




                            	}
                            ?>

                        <?php endif; ##end if have posts ?>

                    <?php do_action ('__after_loop');##hook of the comments and the posts navigation with priorities 10 and 20 ?>

                </div><!--.article-container -->

           <?php do_action( '__after_article_container'); ##hook of left sidebar ?>

        </div><!--.row -->
    </div><!-- .container role: main -->

    <?php do_action( '__after_main_container' ); ?>

</div><!-- //#main-wrapper -->

<?php do_action( '__after_main_wrapper' );##hook of the footer with get_footer ?>
