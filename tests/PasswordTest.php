<?php
use PHPUnit\Framework\TestCase;

final class PasswordTest extends TestCase
{
    private $letters = "abcdefghijklmnopqrstuvwxyz";
    private $numbers = "0123456789";
    private $specialCharacters = " !\"#$%&'()*+,-./:;<=>?@[\]^_`{|}~";

    public function testCanBeCreatedFromValidInputs(): void
    {
        $this->assertInstanceOf(Password::class, Password::generate(20,2,3,2,10));
    }

    public function testCannotBeCreatedFromInvalidLength(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Password::generate(2,6,2,6,2);
    }

    public function testCannotBeCreatedFromStringInputs(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Password::generate("8","2","7","2","3");
    }

    public function testCannotBeCreatedFromInvalidInputs(): void
    {
        $this->expectException(TypeError::class);

        Password::generate("asdgfas","gaws",2,6,2);
    }

    public function testGeneratesPasswordLength(): void
    {
        $password = Password::generate(20,5,1,0,10);

        $this->assertCount(20, str_split($password->getPassword()));
    }

    public function testGeneratesPasswordCorrectly(): void
    {
        $password = Password::generate(40,8,9,10,11);

        $arr = str_split($password->getPassword());

        $result = array_count_values($arr);

        $amountOfUppercaseLetters = 0;
        $amountOfLowercaseLetters = 0;
        $amountOfNumbers = 0;
        $amountOfSpecialsCharacters = 0;

        foreach ($result as $key => $value) {
            if(substr_count($this->letters, $key) === 1)
                $amountOfLowercaseLetters += $value;
            else if(substr_count(strtoupper($this->letters), $key) === 1)
                $amountOfUppercaseLetters += $value;
            else if(substr_count($this->numbers, $key) === 1)
                $amountOfNumbers += $value;
            else if(substr_count($this->specialCharacters, $key) === 1)
                $amountOfSpecialsCharacters += $value;
            else
                throw new Exception("Character isn't part of range");
        }

        $this->assertTrue($amountOfUppercaseLetters >= 8);
        $this->assertTrue($amountOfLowercaseLetters >= 9);
        $this->assertTrue($amountOfNumbers >= 10);
        $this->assertTrue($amountOfSpecialsCharacters >= 11);
    }
}