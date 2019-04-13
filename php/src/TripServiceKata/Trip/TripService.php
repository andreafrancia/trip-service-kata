<?php

namespace TripServiceKata\Trip;

use TripServiceKata\User\User;
use TripServiceKata\User\UserSession;
use TripServiceKata\Exception\UserNotLoggedInException;

class TripService
{
    public function getTripsByUser(User $user)
    {
        $loggedUser = $this->getLoggedInUser();
        if ($loggedUser == null)
            throw new UserNotLoggedInException();

        if (!$user->isFriendOf($loggedUser))
            return [];

        return $this->loadTripsOfUser($user);
    }

    protected function getLoggedInUser()
    {
        return UserSession::getInstance()->getLoggedUser();
    }

    protected function loadTripsOfUser(User $user)
    {
        return TripDAO::findTripsByUser($user);
    }
}
