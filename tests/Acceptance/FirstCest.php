<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
        
    }

    // tests
    public function frontpageWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Home');
        $I->amOnPage('/register.php');
        // $I->submitForm('#registration-form', ['firstname' => 'MilesDavis','middlename'=>'k', 'lastname' => 'com','username'=>'ksb']);
        // $I->see('Thank you for Signing Up!');
// $I->submitForm('#login-form', ['username' => 'MilesDavis', 'email' => 'miles@davis.com']);

    }
}
