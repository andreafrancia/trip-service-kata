<?php

namespace TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use TripServiceKata\Exception\DependentClassCalledDuringUnitTestException;
use TripServiceKata\User\User;

class TripServiceTest extends TestCase
{
    /** @var TripService */
    private $service;

    protected function setUp(): void
    {
        $this->service = new TripService();
    }

    function test_something() {
        $this->expectException(DependentClassCalledDuringUnitTestException::class);
        $this->service->getTripsByUser(new User(null));
    }

}