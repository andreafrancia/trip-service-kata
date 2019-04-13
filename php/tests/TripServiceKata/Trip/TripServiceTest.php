<?php

namespace TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;

class TripServiceTest extends TestCase
{
    function test_something() {
        new TripService();
        self::assertEquals(1,1);
    }
}