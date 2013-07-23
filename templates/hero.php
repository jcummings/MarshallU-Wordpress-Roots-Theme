<section class="page-header hero-unit">
  <h1><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>">
    <?php bloginfo('name'); ?>
    </a></h1>
  <?php  if (is_front_page()) { hero_unit_hook(); } ?>
</section>
<?php if ( has_nav_menu( 'primary_navigation' )){ ?><nav id="site-nav" class="navbar">
<div class="navbar-inner">
  <div class="container">
<a class="btn btn-navbar" data-toggle="collapse" data-target=".subnav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
      <div class="subnav-collapse collapse">
        <?php wp_nav_menu( array('theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'fallback_cb' => '') ); ?>
    </div>
  </div>
  </div>
</nav>
<?php masthead_hook();?>
<?php } ?>
