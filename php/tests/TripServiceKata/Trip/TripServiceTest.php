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

    function test_solo_utenti_loggati_possono_accedere()
    {
        $this->service->setLoggedInUser(null);

        $this->expectException(UserNotLoggedInException::class);

        $this->service->getTripsByUser(new User(""));
    }


    function test_quando_sei_loggato_e_non_sei_amico_non_vedi_viaggi()
    {
        $this->service->setLoggedInUser(new User("logged user"));

        $tripsFound = $this->service->getTripsByUser(new User(""));

        self::assertEquals([], $tripsFound);
    }

    protected function setUp(): void
    {
        $this->service = new TestableTripService();
    }
}