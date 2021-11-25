<?php declare( strict_types = 1 );
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

    /*
     * Registration function
     * Login function
     *  - Reg Username(email)/password(6 len AlphaNumeric atleast one number)
     *      - Save user to file in json
     *  - Loggin Username/Password
     *      - validate that username + password exists
     */
    // Test that the function correctly registers the user with all required fields

    public function testRegistrationFailsWithEmptyUsername() {
        $regobj = new RandomObj();
        $this->assertEquals(
            false, $regobj->register('', '')->isSuccess()
        );
        $this->assertEquals(
            "Username is empty", $regobj->register('', '')->getMessage()
        );
    }

    public function testRegistrationFailsWithEmptyPassword() {
        //Implement this test
        $this->assertEquals(
            "Test implemented", "Not implemented"
        );
    }

    public function testRegistrationFailsWithInValidEmailAddress() {
        $regobj = new RandomObj();
        $invalidEmails = array(
            '@', '123123', "notvalid@faildomain", '@what.com'
        );
        foreach($invalidEmails as $invalidEmail) {
            $this->assertEquals(
                false, $regobj->register($invalidEmail, 'nan')->isSuccess()
            );
            $this->assertEquals(
                "Username is invalid", $regobj->register($invalidEmail, 'adf')->getMessage()
            );
        }
    }

    public function testRegistrationFailsWithInvalidPassword() {
        $regobj = new RandomObj();
        $username = "valid@valid.com";
        $this->assertEquals(
            "Passwords need to be greater than 5 characters", $regobj->register($username, 'nan')->getMessage()
        );
        $this->assertEquals(
            "Passwords must contain at least one digit", $regobj->register($username, 'mehMeh1')->getMessage()
        );
    }

    function testRegistrationReturnSuccessOnValidInputs() {
        $regobj = new RandomObj();
        $username = "valid@valid.com";
        $password = "aRealyGoodPassword123";
        $this->assertEquals(
            '', $regobj->register($username, $password)->getMessage()
        );
    }

    function testLogingFailsForNonExistentUser() {
        $regobj = new RandomObj();
        $username = "NOT EXIST";
        $password = "NOT EXIST";
        $this->assertEquals(
            'User not authenticated', $regobj->login($username, $password)->getMessage()
        );
    }

    function testLoginIsSuccesForValidUser() {
        $regobj = new RandomObj();
        $username = "valid@valid.com";
        $password = "aRealyGoodPassword123";
        $this->assertEquals(
            '{"username":"valid@valid.com","password":""}', $regobj->register($username, $password)->getMessage()
        );
        $this->assertEquals(
            'User authenticated', $regobj->login($username, $password)->getMessage()
        );
    }
}
