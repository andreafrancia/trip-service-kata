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
    }

    function test_only_logged_in_user_can_access()
    {
        $this->expectException(UserNotLoggedInException::class);

        $this->service->getTripsByUser($this->a_user);
    }

    function test_when_user_is_logged_in()
    {
        $this->service->setLoggedInUser($this->a_registed_user);

        $trips = $this->service->getTripsByUser($this->a_stranger);

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