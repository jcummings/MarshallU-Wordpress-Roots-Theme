<?php roots_footer_before(); ?>
 <footer id="content-info" class="footer" role="contentinfo">
    <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span3"><img class="aligncenter" src="<?php echo get_template_directory_uri(); ?>/assets/img/mu_logo_footer.png"  alt="Marshall University logo"></div>
                <div class="span6">
          <p class="aligncenter"><small>Marshall University &bull; One John Marshall Drive &bull; Huntington, WV 25755 &bull; <a href="tel:18006423463">1-800-642-3463</a><br />
            <a href="http://www.marshall.edu/accreditation">Accreditation Info</a> &bull; <a href="http://www.marshall.edu/mumobile/">Mobile App</a> &bull; <script>
document.write('<a href="//muwww-new.marshall.edu/go/index.php?action=shorturl&url=' + document.URL + '">Short Link To This Page</a>');
</script></small></p>
        </div>
        <div class="span3">
          <ul class="social_ico">
            <li class="ico-footer_mailoverseer"><a href="mailto:<?php echo mu_roots_get_options('overseer_email'); ?>">e-Mail the Overseer of this Website</a></li>
            <li class="ico-rss_ico"><a href="http://muwww-new.marshall.edu/connected/rss-directory/">RSS Feed Directory</a></li>
            <li class="ico-youtube_ico"><a href="http://www.youtube.com/herdvideo">Youtube</a></li>
            <li class="ico-smugmug_ico"><a href="http://muphotos.marshall.edu/">Smug Mug</a></li>
            <li class="ico-twitter_ico"><a href="http://muwww-new.marshall.edu/connected/twitter-directory/">Twitter</a></li>
            <li class="ico-facebook_ico"><a href="http://muwww-new.marshall.edu/connected/facebook-directory/">Facebook</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  </footer>
<?php roots_footer_after(); ?>
<?php wp_footer(); ?>