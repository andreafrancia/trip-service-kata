<?php

namespace TripServiceKata\Trip;

use TripServiceKata\User\User;
use TripServiceKata\User\UserSession;
use TripServiceKata\Exception\UserNotLoggedInException;

class TripService
{

    public function getTripsByUser(User $spiedUser) {
        $loggedInUser = $this->getLoggedInUser();
        if ($loggedInUser == null)
            throw new UserNotLoggedInException();
        if (!$spiedUser->isFriendOf($loggedInUser))
            return [];

        return $this->loadTripsForUser($spiedUser);
    }

    protected function getLoggedInUser()
    {
        return UserSession::getInstance()->getLoggedUser();
    }

    protected function loadTripsForUser(User $user)
    {
        return TripDAO::findTripsByUser($user);
    }
}
