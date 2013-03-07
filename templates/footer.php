<?php roots_footer_before(); ?>
 <footer id="content-info" class="footer" role="contentinfo">
    <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span3"><img class="aligncenter" src="<?php echo get_template_directory_uri(); ?>/assets/img/mu_logo_footer.png"  alt="Marshall University logo"></div>
        <div class="span6">
          <p class="aligncenter"><small>Marshall University &bull; One John Marshall Drive &bull; Huntington, WV 25755 &bull; <a href="tel:18006423463">1-800-642-3463</a><br />
            <a href="http://www.marshall.edu/accreditation">Accreditation Info</a> &bull; <a href="http://www.marshall.edu/mumobile/">Mobile App</a></small></p>
        </div>
        <div class="span3">
          <ul class="social_ico">
            <li class="ico-footer_mailoverseer"><a href="mailto:<?php echo mu_roots_get_options('overseer_email'); ?>">e-Mail the Overseer of this Website</a></li>
            <li class="ico-rss_ico"><a href="http://muweb.marshall.edu/wpmu/connected/rss-feed-directory/">RSS Feed Directory</a></li>
            <li class="ico-youtube_ico"><a href="http://www.youtube.com/herdvideo">Youtube</a></li>
            <li class="ico-smugmug_ico"><a href="http://muphotos.marshall.edu/">Smug Mug</a></li>
            <li class="ico-twitter_ico"><a href="http://muweb.marshall.edu/twitter">Twitter</a></li>
            <li class="ico-facebook_ico"><a href="http://www.facebook.com/marshallu">Facebook</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  </footer>
<?php roots_footer_after(); ?>
<?php if (GOOGLE_ANALYTICS_ID): ?>
<script>
  var _gaq=[['_setAccount','<?php echo GOOGLE_ANALYTICS_ID; ?>'],['_trackPageview']];
  (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));

  google.load('search', '1');
  google.setOnLoadCallback(function() {
    google.search.CustomSearchControl.attachAutoCompletion(
      '010773603321931097386:xheprsjc1a8',
      document.getElementById('q'),
      'cse-search-box');
  });
</script>
<?php endif; ?>

<?php wp_footer(); ?>