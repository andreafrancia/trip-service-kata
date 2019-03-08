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

    function test_something()
    {
        $this->service->setLoggedInUser(new User("a registered user"));

        $trips = $this->service->getTripsByUser(new User(null));

        self::assertSame([], $trips);
    }

}

class TestableTripService extends TripService
{
    private $loggedInUser;

    public function setLoggedInUser(User $loggedInUser)
    {
        $this->loggedInUser = $loggedInUser;
    }

    protected function getLoggedInUser()
    {
        return $this->loggedInUser;
    }
}