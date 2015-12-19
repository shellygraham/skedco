<?php

if ( ! class_exists ( 'woo_ps_flat_rate' ) ) {

	class woo_ps_flat_rate {


		private $settings = '';


		function __construct( &$rate ) {

			$this->settings = $rate;

		}



		function get_quotes() {

			if ( isset ( $this->settings['user_facing_name'] ) && isset ( $this->settings['options']['flat']['rate'] ) ) {
				$results[] = Array ( $this->settings['user_facing_name']  => $this->settings['options']['flat']['rate'] );
			} else {
				$results = Array ();
			}
			return $results;

		}


	}

}
