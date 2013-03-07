<section class="page-header hero-unit">
	<h1><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
	       <?php  if (is_front_page()) { hero_unit_hook(); } ?>
</section>
<nav id="site-nav">
	<div class="subnav">
			<div class="container">
					<?php wp_nav_menu( array('theme_location' => 'primary_navigation', 'menu_class' => 'nav nav-pills', 'fallback_cb' => '', 'depth' => 0) ); ?>
		</div>
	</div>
</nav>