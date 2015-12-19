<?php
use \WebGuy;

class Config_EnableCest
{

    public function _before()
    {
    }

    public function _after()
    {
    }

    public function testSignIn(WebGuy $I, $scenario)
    {
        $I->wantTo('sign in');
        $I->amOnPage('/wp-admin/');
        $I->fillField('user_login', $I->getConfig('admin_user_login'));
        $I->fillField('user_pass', $I->getConfig('admin_user_pass'));
        $I->click('wp-submit');
        $I->see('Dashboard');
    }

    public function testWCSettings(WebGuy $I, $scenario)
    {
    	$I->see('WooCommerce');
    	$I->click('a.toplevel_page_woocommerce');
		$I->see("Settings");
		$I->click('admin.php?page=wc-settings');
    }
}
