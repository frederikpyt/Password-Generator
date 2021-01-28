<?php
class HomeController extends Controller
{
    function index($request)
    {
        if(isset($_POST["length"]) && isset($_POST["upperCaseAmount"]) && isset($_POST["lowerCaseAmount"]) && isset($_POST["numbersAmount"]) && isset($_POST["specialCharactersAmount"]))
        {
            try{
                $password = Password::generate($_POST["length"], $_POST["upperCaseAmount"], $_POST["lowerCaseAmount"], $_POST["numbersAmount"], $_POST["specialCharactersAmount"]);
                $passwordStr = $password->getPassword();
            } catch (InvalidArgumentException $e)
            {
                $password = $e->getMessage();
            }

            return $this->render("home.index", ["password" => $passwordStr, "length" => $_POST["length"], "upperCaseAmount" => $_POST["upperCaseAmount"], "lowerCaseAmount" => $_POST["lowerCaseAmount"], "numbersAmount" => $_POST["numbersAmount"], "specialCharactersAmount" => $_POST["specialCharactersAmount"]]);
        }
        else
            return $this->render("home.index", ["length" => 0, "upperCaseAmount" => 0, "lowerCaseAmount" => 0, "numbersAmount" => 0, "specialCharactersAmount" => 0]);
    }
}