<?php

namespace TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use TripServiceKata\Exception\DependentClassCalledDuringUnitTestException;
use TripServiceKata\User\User;

class TestableTripService extends TripService
{

}

class TripServiceTest extends TestCase
{
    /** @var TestableTripService */
    private $service;

    function test_something()
    {
        $this->expectException(DependentClassCalledDuringUnitTestException::class);

        $this->service->getTripsByUser(new User(""));
    }

    protected function setUp(): void
    {
        $this->service = new TestableTripService();
        parent::setUp();
    }
}