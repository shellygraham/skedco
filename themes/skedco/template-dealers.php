<?php /* Template Name: Dealers Template */ get_header(); ?>

<?php get_header(); ?>
<div class="masthead">
  <img src="<?php skedco_random_hero_img() ?>" />
</div>

<div class="container">

	<main role="main">
		<!-- section -->
		<section>
  		
  		
  		
  		
  		<!-- Top Header -->
  		<div class="row intro">
  		  <div class="col-xs-12">
    			<h2 class="">
    				<img src="/wp-content/themes/skedco/img/global-icon.png" width="" height="100px" alt="" class="hidden-xs left" style="margin-right:10px;" />
    				<big><?php the_field('title'); ?></big>
    			</h2>
    			<h3 class="emphasis top-flush" style="clear:none;"><?php the_field('lead-in'); ?></h3>
  		  </div>
  		</div>
  		<hr />
  		
  
  		
  		
  		
  		
  		
  		<!-- Address and Contact Form -->
    <div class="dealers-top-box">
  		<div class="col-sm-3 align-right smaller" id="dealers-row-1">
  			<p><?php the_field('panel_1_text'); ?></p>
  		</div>
  		<div class="col-sm-4" id="dealers-row-2">
  			<h3 class="top-flush" >
  				Contact our rescue product experts today, and we'll connect you with the provider that best suits your needs.
  			</h3>
  		</div>
  		<div class="col-sm-5">
  			<h3 class="emphasis green"><a href="tel:18007707533">Call 1 (800) 770-SKED</a> <small>or write us:</small></h3>
  			<?php if( function_exists( 'ninja_forms_display_form' ) ){ ninja_forms_display_form( 3 ); } ?>
  			<small><i>Skedco answers your queries on weekdays as received.</i></small>
  		</div>
	   	<br class="clear" />
    </div>
  		  
		<!-- Midpage header -->
		<h2 class="emph green"><?php the_field('panel_2_left_side_text'); ?></h2>
  		  
    <hr/>
		<!-- Green list and image -->
    <div class="dealer-middle-box">
  		<div class="col-sm-6" id="green-list">
  			<div>
  			<h3>Benefits of Buying From a Provider:</h3>
  			<ul>
  				<li>Best Prices</li>
  				<li>Rapid Delivery</li>
  				<li>Local Training</li>
  				<li>Product selection assistance</li>
  			</ul>
  			</div>
  		</div>
  		<div class="col-sm-6" id="skedco-five-ways">
  			<h3>Five Ways to Buy SKEDCO Products</h3>
  			<img src="<?php the_field('panel_2_right_side_image'); ?>" class="scale-to-grid img-responsive">
  			<small>Note: Products ordered directly from the Skedco website can only be shipped to the continental United States.</small>
  		</div>
    </div>
  		
    <hr/>
  		<br class="clear hidden-sm hidden-xs" />
  		<br class="clear hidden-sm hidden-xs" />

  		
  		<!-- Outside the USA and Rescue Training -->
  		<div class="row more-contact">
  		  <div class="col-sm-6">
  		    <h3>Outside the USA</h3>
  		    <iframe src="https://mapsengine.google.com/map/u/0/embed?mid=zfCCzNRayZ0o.kenIAm0cZ61o" width="555" height="300"></iframe>
  		    <ul>
    		    <li>
    		      <div class="btn-group">
    		        <div class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-plus"></span>
                  <h4><?php the_field('intl_location_1'); ?></h4>
                </div>
        		    <div class="dropdown-menu">
          		    <p><?php the_field('intl_location_1_details'); ?></p>
        		    </div>
    		      </div>
    		    </li>
    		    <li>
    		      <div class="btn-group">
    		        <div class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-plus"></span>
                  <h4><?php the_field('intl_location_2'); ?></h4>
                </div>
        		    <div class="dropdown-menu">
          		    <p><?php the_field('intl_location_2_details'); ?></p>
        		    </div>
              </div>
    		    </li>
    		    <li>
    		      <div class="btn-group">
    		        <div class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-plus"></span>
                  <h4><?php the_field('intl_location_3'); ?></h4>
    		        </div>
        		    <div class="dropdown-menu">
          		    <p><?php the_field('intl_location_3_details'); ?></p>
        		    </div>
    		      </div>
    		    </li>
    		    <li>
    		      <div class="btn-group">
    		        <div class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-plus"></span>
                  <h4><?php the_field('intl_location_4'); ?></h4>
                </div>
        		    <div class="dropdown-menu">
          		    <p><?php the_field('intl_location_4_details'); ?></p>
        		    </div>
    		      </div>
    		    </li>
    		    <li>
    		      <div class="btn-group">
    		        <div class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-plus"></span>
                  <h4><?php the_field('intl_location_5'); ?></h4>
                </div>
        		    <div class="dropdown-menu">
          		    <p><?php the_field('intl_location_5_details'); ?></p>
        		    </div>
    		      </div>
    		    </li>
  		    </ul>
  		    <p class="fine-print">Don't see your territory? Contact us using the form above.</p>
  		  </div>
  		  <div class="col-sm-6">
  		    <h3>Looking for Rescue Training?</h3>
  		    <img class="img-responsive" src="<?php the_field('training_image'); ?>" width="" height="" alt="" />
  		    <p class="caption"><?php the_field('training_caption'); ?></p>
  		  </div>
  		</div>
		</section>
		<!-- /section -->
	</main>
</div>
<?php get_footer(); ?>

