<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

// php artisan make:test CategoryTest --unit
// vendor/bin/phpunit
// vendor/bin/phpunit —filter CategoryTest
// vendor/bin/phpunit —-filter CategoryTest
// vendor/bin/phpunit —-filter CategoryTest::testExample

// Testar uma classe inteira:
// Vendor/bin/phpunit tests/Unit/CategoryTest.php
// Executar um teste em específico
// Vendor/bin/phpunit  —-filter nomedotest tests/Unit/CategoryTest.php

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }
}
