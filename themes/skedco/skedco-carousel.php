<div id="myCarousel" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<!--
	<ol class="carousel-indicators">
		<?php 
			$args = array( 'post_type' => 'home-slider', 'posts_per_page' => 10 , 'orderby' => 'menu_order', 'order' => 'ASC');
			$number = 0;
			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<li data-target="#myCarousel" data-slide-to="<?php echo $number++; ?>"></li>
			<?php $i++;
			endwhile; 
		?>
	</ol>
	-->
            
	<div class="carousel-inner">
					
		<?php $args = array( 'post_type' => 'home-slider', 'posts_per_page' => 1, 'orderby' => 'menu_order', 'order' => 'ASC' );
			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post();
			echo '<div class="item active">';
			the_post_thumbnail();
			echo '<div class="container">';
			echo '<div class="carousel-caption">';
			echo '<h1>';
			echo the_title();
			echo '</h1>';
			echo the_content(); ?>

	<?php if(get_field('slider_button_link')) {
		echo '<a class="btn-carousel hidden-xs" href="' . get_field('slider_button_link') . '">' . get_field('slider_button_text') . '</a>';
	} ?>

	<?php
		echo '</div>';
		echo '</div>';
		echo '</div>';
		endwhile; wp_reset_postdata(); ?>
								
		<?php $args = array( 'post_type' => 'home-slider', 'posts_per_page' => 10, 'offset' => 1, 'orderby' => 'menu_order', 'order' => 'ASC' );
			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post();
			echo '<div class="item">';
			the_post_thumbnail();
			echo '<div class="container">';
			echo '<div class="carousel-caption">';
			echo '<h1>';
			echo the_title();
			echo '</h1>';
			echo the_content(); ?>

	<?php if(get_field('slider_button_link')) {
		echo '<a class="btn-carousel hidden-xs" href="' . get_field('slider_button_link') . '">' . get_field('slider_button_text') . '</a>';
	} ?>

	<?php
		echo '</div>';
		echo '</div>';
		echo '</div>';
		endwhile; wp_reset_postdata(); ?>
	</div>
	<a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
	<a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
	<div class="topic-banner-bg hidden-sm hidden-xs"></div>
	<div class="topic-banner hidden-sm hidden-xs">
		<div class="container">
			<ul class="col-xs-12 col-sm-11 col-sm-offset-1 col-md-9 col-md-offset-2">
				<li data-target="#myCarousel" data-slide-to="0"><span class="hover-shape"></span><a class="topic1 fire-rescue" href="">Fire &amp; Rescue</a></li>
				<li data-target="#myCarousel" data-slide-to="1"><span class="hover-shape"></span><a class="topic2 medical" href="">Medical</a></li>
				<li data-target="#myCarousel" data-slide-to="2"><span class="hover-shape"></span><a class="topic3 hazmat" href="">Hazmat</a></li>
				<li data-target="#myCarousel" data-slide-to="3"><span class="hover-shape"></span><a class="topic4 industrial" href="">Industrial</a></li>
				<li data-target="#myCarousel" data-slide-to="4"><span class="hover-shape"></span><a class="topic5 military" href="">Military</a></li>
			</ul>
		</div>
	</div>
</div><!-- /.carousel -->
<!--<div class="carousel menu"> 
	<div class="container">
		<div class="col-sm-6">
			<a href="/industry-solutions/fire-rescue" id="fire-rescue">Fire &amp; Rescue</a>
			<a href="/industry-solutions/medical" id="medical">Medical</a>
			<a href="/industry-solutions/hazmat" id="hazmat">Hazmat</a>
		</div>
		<div class="col-sm-6">
			<a href="/industry-solutions/industrial" id="industrial">Industrial</a>
			<a href="/industry-solutions/military" id="military">Military</a>
		</div>
	</div>
</div>-->
