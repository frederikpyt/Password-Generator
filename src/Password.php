<?php
final class Password
{
    private $password = "";
    private $letters = "abcdefghijklmnopqrstuvwxyz";
    private $numbers = "0123456789";
    private $specialCharacters = " !\"#$%&'()*+,-./:;<=>?@[\]^_`{|}~";

    private function __construct(int $length, int $UppercaseLetterAmount, int $LowercaseLetterAmount, int $numberAmount, int $specialCharacterAmount)
    {
        $this->ensureIsValidInput($length, $UppercaseLetterAmount, $LowercaseLetterAmount, $numberAmount, $specialCharacterAmount);

        $password = "";

        //Add the uppercase letters
        for ($i = 0; $i < $UppercaseLetterAmount; $i++){
            $password .= substr(str_shuffle(ucwords($this->letters)), 0, 1);
        }

        //Add the lowercase letters
        for ($i = 0; $i < $LowercaseLetterAmount; $i++){
            $password .= substr(str_shuffle($this->letters), 0, 1);
        }

        //Add the numbers
        for ($i = 0; $i < $numberAmount; $i++){
            $password .= substr(str_shuffle($this->numbers), 0, 1);
        }

        //Add the special characters
        for ($i = 0; $i < $specialCharacterAmount; $i++){
            $password .= substr(str_shuffle($this->specialCharacters), 0, 1);
        }

        //If all specific character requirements are met, then randomize the rest, so that it matches the provided password length
        if(strlen($password) < $length)
        {
            $possibleChars = $this->letters.ucwords($this->letters).$this->numbers.$this->specialCharacters;
            $missingCharacters = $length - strlen($password);

            for ($i = 0; $i < $missingCharacters; $i++) {
                $password .= substr(str_shuffle($possibleChars), 0, 1);
            }
        }

        $this->password = str_shuffle($password);
    }

    public static function generate(int $length, int $UppercaseLetterAmount, int $LowercaseLetterAmount, int $numberAmount, int $specialCharacterAmount)
    {
        return new self($length, $UppercaseLetterAmount, $LowercaseLetterAmount, $numberAmount, $specialCharacterAmount);
    }

    private function ensureIsValidInput(int $length, int $UppercaseLetterAmount, int $LowercaseLetterAmount, int $numberAmount, int $specialCharacterAmount): void
    {
        if($length < ($UppercaseLetterAmount+$LowercaseLetterAmount+$numberAmount+$specialCharacterAmount)) {
            throw new InvalidArgumentException(sprintf(
                'Provided length: "%s" is lower than combined character requirements',
                $length
            ));
        }
    }
}