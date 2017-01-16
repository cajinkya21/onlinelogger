<?php
/*
Template Name: login
*/

?>
<?php session_start(); $_SESSION["uname"] = "Tushar" ?>

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

                           	<?php //The login code goes here?>
                           	<?php
                           	if(!($_POST["uname"])){
                           echo "	<form action = \"#\" method = \"post\">                           		User Name:- <input type = \"text\" name = \"uname\" width=\"1\" placeholder=\"username\">                           		<br/>                           		Password:- &nbsp;&nbsp;<input type = \"password\" name = \"upass\" placeholder=\"password\">                           		<br/>                           	<center>	<input type = \"submit\" value = \"login\"> </center>                           	</form>";
                       }
							?>
                           	<?php
                           		if($_POST["uname"]){
                           			$_SESSION["uname"] = $_POST["uname"];
                           			if(strcmp($_POST["uname"], "Tushar") == 0){
                           				if(strcmp($_POST["upass"], "qwerty") == 0){
                           					echo "<center>  Welcome ".$_SESSION["uname"]." You are Logged in";
                           					echo "                         					<form action = \"http://localhost/onlineLog/index.php/sample-page/Admin/\" method = \"post\">                           						<input type = \"submit\" value = \"Done login, click here now!\">                           					</form> </center>";
                           				}
                           				else
                           					echo "Please enter the correct credentials";
                           			}
                           			else
                           				echo "Please enter the correct credentials";
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
