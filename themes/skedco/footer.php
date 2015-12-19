			<!-- footer -->
			<div class="subfooter">
			  <div class="container">
          <div class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
            <a class="footer-brand" href="<?php echo home_url(); ?>">
              <?php echo $blog_title = get_bloginfo(); ?>
            </a>
          </div>
          <div class="col-xs-8 col-xs-offset-2 col-sm-offset-0 col-sm-3 col-md-offset-0 col-md-3 col-lg-2">
            <ul class="footer-pages">
              <li><a href="/shop">Products</a></li>
              <li><a href="/industry-solutions">Industry&nbsp;Solutions</a></li>
              <li><a href="/rescue-line">The&nbsp;Rescue&nbsp;Line</a></li>
              <li><a href="/forums">Forums</a></li>
              <li><a href="/training">Training</a></li>
              <li><a href="/about/dealers">Dealers</a></li>
              <li><a href="/about">About</a></li>
            </ul>
          </div>
          <div class="col-xs-12 col-sm-2">
            <ul class="footer-social">
              <li><a class="youtube" href="http://www.youtube.com/user/skedcoInc" target="_blank">YouTube</a></li>
              <li><a class="googleplus" href="https://plus.google.com/115546381465209422158/about" target="_blank">Google&#43;</a></li>
              <li><a class="facebook" href="https://www.facebook.com/pages/Skedco/214181008646361" target="_blank">Facebook</a></li>
            </ul>
          </div>
          <div class="col-xs-12 col-sm-5 col-sm-offset-0 col-md-5 col-md-offset-0 col-lg-6 col-lg-offset-1 contact">
            <?php if( function_exists( 'ninja_forms_display_form' ) ){ ninja_forms_display_form( 2 ); } ?>
            <p>Skedco, Inc.</p>
            <p><a href="https://www.google.com/maps/place/10505+SW+Manhasset+Dr/@45.379429,-122.785493,17z/data=!3m1!4b1!4m2!3m1!1s0x54956d6485d8d60f:0xca5e433b00e71c4f" target="_blank" title="See map of this location">10505 SW Manhasset Drive Tualatin, OR 97062</a></p>
            <p class="emph"><a href="tel:18007707533">1-800-770-SKED</a> / <a href="mailto:skedco@skedco.com?subject=Inquiry from the Skedco.com">skedco@skedco.com</a></p>
            <p class="emph">Fax: (503) 691-7973</p>
          </div>
			  </div>
			</div>
			<footer class="footer" role="contentinfo">
			  <div class="container">

  				<!-- copyright -->
  				<p class="copyright">
  					&copy; Copyright <?php echo date('Y'); ?> - <a href="<?php echo home_url() ?>"><?php bloginfo('name'); ?>, Inc.</a> All rights reserved.
  					A <a href="//popart.com" title="Pop Art">Pop Art</a><span>&reg;</span> Production.
  				</p>
  				<!-- /copyright -->
  				<p class="fine-type">
            <a href="/about/privacy-policy/">Privacy Policy</a>
            <a href="/sitemap_index.xml">Site Map</a>
  				</p>

			  </div>
			</footer>
			<!-- /footer -->

		</div>
		<!-- /wrapper -->

		<?php wp_footer(); ?>

		<!-- analytics -->
		<script>
		(function(f,i,r,e,s,h,l){i['GoogleAnalyticsObject']=s;f[s]=f[s]||function(){
		(f[s].q=f[s].q||[]).push(arguments)},f[s].l=1*new Date();h=i.createElement(r),
		l=i.getElementsByTagName(r)[0];h.async=1;h.src=e;l.parentNode.insertBefore(h,l)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-15544980', 'skedco.com');
		ga('send', 'pageview');
		</script>

    <script src="<?php echo get_template_directory_uri(); ?>/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/docs.min.js"></script>

	</body>
</html>
