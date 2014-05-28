<?php roots_pageheader_before(); ?>

<?php
//Added to fix Cross Domain Ajax from breaking when switching from http/https
global $blog_id;
if ($blog_id == 355) {
   header('X-Frame-Options: MindsofMarshall');
}

/*
* Check for any alerts that the user might have added that should be displayed at the top of the page
*/
if ( get_query_var('paged') ) $paged = get_query_var('paged');  
if ( get_query_var('page') ) $paged = get_query_var('page');
 
$query = new WP_Query( array( 'post_type' => 'mu-page-alert', 'showposts' => 1, 'paged' => $paged ) );
 
if ( $query->have_posts() ) : ?>
	<?php while ( $query->have_posts() ) : $query->the_post(); ?>	
		<!--Do we have meta data for the type of alert that they want?-->
		<?php
			//$alert_key = get_post_meta( get_the_ID(), 'fp_alert_metabox_select', true );
			$alertType = get_post_meta( get_the_ID(), 'fp_alert_meta_box_select', true );
			// check if the custom field has a value
			if( empty( $alertType )) {
			?>
			  <div class="alert">
			<?php
			} 
			else{
			  echo "<div class='alert " . $alertType ."'>";
			
			}
		?>
		
		
		
			<h2 class="title"><?php the_title(); ?></h2>
			<?php the_content(); ?>	
		</div>
	<?php endwhile; wp_reset_postdata(); ?>
	<!-- show pagination here -->
<?php else : ?>
	<!-- show 404 error here -->
<?php endif; ?>
<!--
	End Front page alert code
-->


<div class="page-header">
  <h1>
    <?php echo roots_title(); ?>
  </h1>
</div>