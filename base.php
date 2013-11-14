<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <?php
    do_action('get_header');
    get_template_part('templates/header-top-navbar');
  ?>
<div id="wrapper" class="clearfix">
  <div id="wrap" class="container" role="document">
   <?php get_template_part('templates/hero'); ?>
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
   <?php get_template_part('templates/pagemeta'); ?>
  </div><!-- /.wrap -->
  <div class="footer-push">&nbsp;</div>
 </div><!-- /#wrapper -->

  <?php get_template_part('templates/footer'); ?>

</body>
</html>
