<?php

namespace TaylorNetwork\MakeHTML\Tests;

use Orchestra\Testbench\TestCase;
use TaylorNetwork\MakeHTML\HTMLGenerator;

class HTMLTest extends TestCase
{
    /**
     * @var HTMLGenerator
     */
    public $generator;

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    public function getPackageProviders($app)
    {
        return ['TaylorNetwork\\MakeHTML\\MakeHTMLServiceProvider'];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    public function getEnvironmentSetUp($app)
    {
        $this->generator = new HTMLGenerator();

        // Require these manually for testing, Laravel will allow them to work globally in an installation.
        require __DIR__.'/../vendor/taylornetwork/laravel-helpers/src/helpers/associative-implode/src/associative_implode.php';
        require __DIR__.'/../vendor/taylornetwork/laravel-helpers/src/helpers/replace-variables/src/replace_variables.php';
    }

    public function testLineBreaksPHP_EOL()
    {
        $string = 'This'.PHP_EOL.'has'.PHP_EOL.'line'.PHP_EOL.'breaks.';
        $expected = 'This<br />'.PHP_EOL.'has<br />'.PHP_EOL.'line<br />'.PHP_EOL.'breaks.';

        $this->assertEquals($expected, $this->generator->convertLineEndings($string));
    }

    public function testGenerateLinkTag()
    {
        $expected = '<a href="http://google.com" class="test-class">Link Name</a>';

        $this->assertEquals($expected, $this->generator->generateTag('a', [
            'href'     => 'http://google.com',
            'class'    => 'test-class',
            'external' => 'Link Name',
        ]));
    }

    public function testLinksMakeHTML()
    {
        $string = 'This has a link http://test.com/1/2/3/page?t=2 and that\'s all.';
        $expected = 'This has a link <a target="_blank" href="http://test.com/1/2/3/page?t=2">test.com</a> and that\'s all.';

        $this->assertEquals($expected, $this->generator->makeHTML($string));
    }

    public function testLineBreaksAndLinks()
    {
        $string = 'This is a'.PHP_EOL.'line break and a link'.PHP_EOL.
            'http://test.com/1/2/3?page=3 and more line'.PHP_EOL.'breaks!';

        $expected = 'This is a<br />'.PHP_EOL.'line break and a link<br />'.PHP_EOL.
            '<a target="_blank" href="http://test.com/1/2/3?page=3">test.com</a> and more line<br />'.PHP_EOL.'breaks!';

        $this->assertEquals($expected, $this->generator->makeHTML($string));
    }
}
