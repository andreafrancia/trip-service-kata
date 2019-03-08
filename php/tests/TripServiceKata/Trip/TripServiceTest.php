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
    private $a_user;
    private $a_stranger;
    private $a_registed_user;

    protected function setUp(): void
    {
        $this->a_registed_user = new User("a registered user");
        $this->a_stranger = new User(null);
        $this->a_user = new User(null);
        $this->service = new TestableTripService();
        $this->a_friend = new User("a friend");
        $this->a_friend->addFriend($this->a_registed_user);

    }

    function test_only_logged_in_user_can_access()
    {
        $this->expectException(UserNotLoggedInException::class);

        $this->service->getTripsByUser($this->a_user);
    }

    function test_can_not_see_trips_of_a_stranger()
    {
        $this->service->setLoggedInUser($this->a_registed_user);

        $trips = $this->service->getTripsByUser($this->a_stranger);

        self::assertSame([], $trips);
    }

    function test_can_see_trips_of_a_friend()
    {
        $this->service->setLoggedInUser($this->a_registed_user);

        $trips = $this->service->getTripsByUser($this->a_friend);

        self::assertSame("trips of user", $trips);
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
    protected function loadTripsForUser(User $user)
    {
        return "trips of user";
    }
}