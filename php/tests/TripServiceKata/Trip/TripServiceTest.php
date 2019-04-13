<?php

namespace TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use TripServiceKata\Exception\DependentClassCalledDuringUnitTestException;
use TripServiceKata\Exception\UserNotLoggedInException;
use TripServiceKata\User\User;

class TestableTripService extends TripService
{
    protected function getLoggedInUser()
    {
        return null;
    }
}

class TripServiceTest extends TestCase
{
    /** @var TestableTripService */
    private $service;

    function test_se_non_sei_loggato_non_puoi_utilizzare_il_servizio()
    {
        $this->expectException(UserNotLoggedInException::class);

        $this->service->getTripsByUser(new User(""));
    }

    protected function setUp(): void
    {
        $this->service = new TestableTripService();
        parent::setUp();
    }
}