<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

//add
use Illuminate\Foundation\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, TestHelpers, DetectRepeatedQueries;

    //add
    protected $defaultData = [];

    public function setUp()
    {
        parent::setUp();

        TestResponse::macro('viewData', function ($key) {
            $this->ensureResponseHasView();
            $this->assertViewHas($key);
            return $this->original->$key;
        });

        TestResponse::macro('assertViewCollection', function ($var) {
            return new TestCollectionData($this->viewData($var));
        });

        $this->withoutExceptionHandling();

        $this->enableQueryLog();
    }

    public function tearDown()
    {
        $this->flushQueryLog();
        parent::tearDown();
    }
}
