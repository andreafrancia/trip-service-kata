<?php

namespace TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use TripServiceKata\Exception\DependentClassCalledDuringUnitTestException;
use TripServiceKata\Exception\UserNotLoggedInException;
use TripServiceKata\User\User;

class TestableTripService extends TripService
{
    private $loggedInUser;

    public function setLoggedInUser($loggedInUser): void
    {
        $this->loggedInUser = $loggedInUser;
    }

    protected function getLoggedInUser()
    {
        return $this->loggedInUser;
    }
}

class TripServiceTest extends TestCase
{
    /** @var TestableTripService */
    private $service;

    function test_se_non_sei_loggato_non_puoi_utilizzare_il_servizio()
    {
        $this->service->setLoggedInUser(null);

        $this->expectException(UserNotLoggedInException::class);

        $this->service->getTripsByUser(new User(""));
    }


    function test_quando_sei_loggato()
    {
        $this->service->setLoggedInUser(null);

        $this->expectException(UserNotLoggedInException::class);

        $this->service->getTripsByUser(new User(""));
    }

    protected function setUp(): void
    {
        $this->service = new TestableTripService();
    }
}