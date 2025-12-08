<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use \Illuminate\Foundation\Testing\RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $testOutputsDir = base_path('test-outputs');

        if (!file_exists($testOutputsDir)) {
            mkdir($testOutputsDir, 0755, true);
        }
    }
}
