<?php

namespace TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use TripServiceKata\Exception\DependentClassCalledDuringUnitTestException;
use TripServiceKata\Exception\UserNotLoggedInException;
use TripServiceKata\User\User;

class TripServiceTest extends TestCase
{
    /** @var TestableTripService */
    private $service;

    protected function setUp(): void
    {
        $this->service = new TestableTripService();
    }

    function test_only_logged_in_user_can_access()
    {
        $this->expectException(UserNotLoggedInException::class);

        $this->service->getTripsByUser(new User(null));
    }

}

class TestableTripService extends TripService
{
    protected function getLoggedInUser()
    {
        return null;
    }
}