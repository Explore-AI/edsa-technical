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
        $regobj = new RandomObj();
        $this->assertEquals(
            false, $regobj->register('asdf', '')->isSuccess()
        );

        $this->assertEquals(
            "Password is empty", $regobj->register('asdf', '')->getMessage()
        );
    }

    public function testRegistrationFailsWithInValidEmailAddress() {
        $regobj = new RandomObj();
        $invalidEmails = array(
            '@', '123123', "asdf@asdf", '@sdfg.com'
        );
        foreach($invalidEmails as $invalidEmail) {
            $this->assertEquals(
                false, $regobj->register($invalidEmail, 'adf')->isSuccess()
            );
            $this->assertEquals(
                "Username is invalid", $regobj->register($invalidEmail, 'adf')->getMessage()
            );
        }
    }

    public function testRegistrationFailsWithInvalidPassword() {
        $regobj = new RandomObj();
        $username = "asdf@asdf.com";
        $this->assertEquals(
            "Passwords need to be greater than 5 characters", $regobj->register($username, 'adf')->getMessage()
        );
        $this->assertEquals(
            "Passwords must contain at least one digit", $regobj->register($username, 'adfaaA')->getMessage()
        );
    }

    function testRegistrationReturnSuccessOnValidInputs() {
        $regobj = new RandomObj();
        $username = "asdf@asdf.com";
        $password = "asdfg1";
        $this->assertEquals(
            '{"username":"asdf@asdf.com","password":"71f713f7c9f356ea3b3a54bcb3452642196347a48f55d1c9b71c154373a7a131"}', $regobj->register($username, $password)->getMessage()
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
        $username = "asdfasdfasdfasdf@asdfasdf.com";
        $password = "asdfasdf1234";
        $this->assertEquals(
            '{"username":"asdfasdfasdfasdf@asdfasdf.com","password":"0755f987080856f8215b78c52f1b0796a69436be5fdba60be0ccf73c7aa3c23f"}', $regobj->register($username, $password)->getMessage()
        );
        $this->assertEquals(
            'User authenticated', $regobj->login($username, $password)->getMessage()
        );
    }
}
