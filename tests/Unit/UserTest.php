<?php

namespace Tests\Unit;
require_once __DIR__ . '/../../classes/users.php';

use Tests\Support\UnitTester;
use \classes\Users;


class UserTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testValidation()
    {
       
       $user = new Users();
        $user->setName(null);
        $this->assertFalse($user->validate(['username']));

       
}
}