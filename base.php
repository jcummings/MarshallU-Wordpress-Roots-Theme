<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <?php
    do_action('get_header');
    // Use Bootstrap's navbar if enabled in config.php
    if (current_theme_supports('bootstrap-top-navbar')) {
      get_template_part('templates/header-top-navbar');
    } else {
      get_template_part('templates/header');
    }
  ?>
<div id="wrapper" class="clearfix">
  <div id="wrap" class="container" role="document">
    <div class="content row">
      <div class="main <?php echo roots_main_class(); ?>" role="main">
        <?php include roots_template_path(); ?>
      </div><!-- /.main -->
      <?php if (roots_display_sidebar()) : ?>
      <aside CLASS="sidebar <?php echo roots_sidebar_class(); ?>" ROLE="complementary">
        <?php include roots_sidebar_path(); ?>
      </aside><!-- /.sidebar -->
      <?php endif; ?>
    </div><!-- /.content -->
   <?php get_template_part('templates/footerwidgets'); ?>
  </div><!-- /.wrap -->
  <div class="footer-push">&nbsp;</div>
 </div><!-- /#wrapper -->

  <?php get_template_part('templates/footer'); ?>

</body>
</html>
