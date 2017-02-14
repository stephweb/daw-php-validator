<?php

namespace Tests\DawPhpValidator;

use PHPUnit\Framework\TestCase;
use DawPhpValidator\Validator;
use DawPhpValidator\Message;

class ValidatorTest extends TestCase
{
    public function testIsNotValid()
    {
        $_POST['test'] = '1';

        Validator::extend('test_strictly_equal', function ($input, $value, $parameters) {
            return ((string) $value === (string) $parameters);
        }, 'Error !');

        $validator = new Validator();

        $validator->rules([
            'test' => [
                'alpha' => true,
                'test_strictly_equal' => '1',
            ],
        ]);

        $this->assertFalse($validator->isValid());
        $this->assertTrue($validator->hasError('test'));
        $this->assertFalse($validator->hasError('testzzz'));
        $this->assertTrue(is_string($validator->getError('test')));
        $this->assertTrue(is_array($validator->getErrors()));
        $this->assertEquals(1, count($validator->getErrors()));
        $this->assertTrue($validator->getMessages() instanceof Message);
        $this->assertTrue(is_string($validator->getMessages()->toJson()));
        $this->assertTrue(is_string($validator->getMessages()->toHtml()));
        $this->assertTrue(is_string($validator->getErrorsHtml()));
        $this->assertTrue(is_string($validator->getErrorsJson()));
    }


    public function testIsValid()
    {
        $_POST['test'] = 'aaa';

        $validator = new Validator();

        $validator->rules([
            'test' => [
                'alpha' => true,
            ],
        ]);

        $this->assertTrue($validator->isValid());
        $this->assertFalse($validator->hasError('test'));
        $this->assertEquals(0, count($validator->getErrors()));
    }


    public function testAddErrorWithInput()
    {
        $validator = new Validator();

        $validator->addErrorWithInput('test_input', 'Error !');

        $this->assertTrue($validator->hasError('test_input'));
        $this->assertFalse($validator->isValid());
    }


    public function testAddError()
    {
        $validator = new Validator();

        $validator->addError('Error !');

        $this->assertFalse($validator->isValid());
    }

}
