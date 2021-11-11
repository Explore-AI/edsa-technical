<?php declare(strict_types=1);
include "RandomObj.php";
use PHPUnit\Framework\TestCase;

//  To install PHP Unit
//  wget -O phpunit https://phar.phpunit.de/phpunit-9.phar
//  chmod +x phpunit
//  ./phpunit --version
//
//  To run tests
//  ./phpunit  tests


final class TechnicalTest extends TestCase
{
    public function testisUsernameAndPasswordFound() {
        $username = "";
        $password = "";
        $regobj = new RandomObj();
        $functionReturn = false;
        $this->assertEquals(
            $regobj->register(), true
        );
    }

    /*
     * Users username needs to be a valid email
     */

    /*
     * Users password needs to be >= 6 length and have Alpha and atleast 1 number
     */

    /*
     * Return datastructure that would be written to a datastore
     */
    public function testValidationPassesUserIsRegistered() {

    }
}
