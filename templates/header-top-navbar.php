<header id="branding" class="banner" role="banner">
  <nav id="secondary-nav" class="navbar navbar-fixed-top" role="navigation">
		<div class="navbar-inner">
			<div class="container">
				<?php
if ( has_nav_menu( 'toolbar' ) ) {?>
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
				<?php } ?>
				<a class="brand" href="http://www.marshall.edu">Marshall University</a>
				<div class="nav-collapse collapse">
				       <form action="http://www.marshall.edu/searchresults.asp" id="cse-search-box" class="navbar-search">
            <input type="hidden" name="cx" value="010773603321931097386:xheprsjc1a8" />
            <input type="hidden" name="cof" value="FORID:10" />
            <input type="hidden" name="ie" value="UTF-8" />
            <input type="text" id="q" name="q" autocomplete="off" class="search-query">
          </form>
					<?php wp_nav_menu(array('theme_location' => 'toolbar', 'menu_class' => 'nav pull-right', 'fallback_cb' => '')); ?>
				</div>
			</div>
		</div>
		</nav>
 <?php
if ( has_nav_menu( 'marshall-menu' ) ) {?>
	<nav id="primary-nav">
		<div class="container">
			<div class="navbar">
				<div class="nav-collapse collapse">
					<?php /*

    Our navigation menu.  If one isn't filled out, wp_nav_menu falls
    back to wp_page_menu.  The menu assigned to the primary position is
    the one used.  If none is assigned, the menu with the lowest ID is
    used. */

    wp_nav_menu( array('theme_location' => 'marshall-menu', 'menu_class' => 'nav', 'fallback_cb' => '') ); ?>
				</div>
			</div>
		</div>
	</nav>
	<?php }?>
		</header>
<?php roots_header_after(); ?>
