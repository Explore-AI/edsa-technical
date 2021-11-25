<?php

class Response
{
    private $success;
    private $message;

    private function __construct($success, $message) {
        $this->success = $success;
        $this->message = $message;
    }

    public static function asSuccess($message = "") {
        return new Response(true, $message);
    }

    public static function asFailure($message = "") {
        return new Response(false, $message);
    }

    public function isSuccess() {
        return $this->success;
    }

    public function getMessage() {
        return $this->message;
    }
}

class RandomObj
{
    /*
     * This function is used for capturing username and password, and saving it to a data store
     * For later security validation
     */
    public function register($username, $password): Response {

        if (!isset($username) || $username === '') {
            return Response::asFailure("Username is empty");
        }
        if (!isset($password) || $password === '') {
            return Response::asFailure("Password is empty");
        }
        if (!$this->isValidUsername($username)) {
            return Response::asFailure("Username is invalid");
        }
        $passwordValidation = $this->isPasswordValid($password);
        if (!$passwordValidation->isSuccess()) {
            return Response::asFailure($passwordValidation->getMessage());
        }
        //SAVE USER
        $user = $this->saveUser($username, $password);

        //RETURN USER DATA
        return Response::asSuccess($user);
    }

    private function isValidUsername($username) {
        //Email validation - Chat about solution or implement on
    }

    private function isPasswordValid($password) {
        // Password validation
        return Response::asSuccess();
    }

    private function saveUser($username, $password) {
        $user = json_encode(array('username' => $username, 'password' => $this->getPasswordNonReadable($password)));
        file_put_contents("users.txt", $user);
        return $user;
    }

    private function getPasswordNonReadable($data) {
        return $data; //Implement / add password obfuscation
    }

    public function login($username, $password) {
        $users = explode('\n', file_get_contents("users.txt"));
        foreach($users as $user) {
            if ($user != "") {
                $JSONData = json_decode($user, true);
                if ($username == $JSONData['username'] && $this->getPasswordNonReadable($password) == $JSONData['password']) {
                    return Response::asSuccess("User authenticated");
                }
            }
        }
        return Response::asFailure("User not authenticated");
    }

}
