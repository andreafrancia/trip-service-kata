<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit_Framework_TestCase;
use TripServiceKata\Exception\DependentClassCalledDuringUnitTestException;
use TripServiceKata\Exception\UserNotLoggedInException;
use TripServiceKata\Trip\Trip;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TripServiceTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->service = new TestableTripService();
        $this->spione = new User(null);
        $this->spiato = new User(null);
    }

    public function test_when_user_is_not_logged_in_it_will_throw_an_exception() {

        $this->expectException(UserNotLoggedInException::class);
        $this->service->getTripsByUser($this->spiato);
    }

    public function test_when_user_is_logged_in_but_is_not_a_friend_the_list_is_empty() {

        $this->service->setLoggedInUser($this->spione);
        $trips = $this->service->getTripsByUser($this->spiato);

        self::assertEquals(array(), $trips);
    }

    public function test_1() {

        $this->service->setLoggedInUser($this->spione);
        $this->spiato->addFriend($this->spione);

        $trip = $this->service->getTripsByUser($this->spiato);

        self::assertEquals(null, $trip);
    }
}

class TestableTripService extends TripService
{
    private $loggedInUser;

    public function getLoggedInUser()
    {
        return $this->loggedInUser;
    }

    public function setLoggedInUser($param)
    {
        $this->loggedInUser = $param;
    }
    protected function findTripsByUser(User $user)
    {
        return null;
    }
}
