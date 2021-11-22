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
            "User Registration Success", $regobj->register($username, $password)->getMessage()
        );
    }
}
