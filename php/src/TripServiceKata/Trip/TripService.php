<?php

namespace TripServiceKata\Trip;

use TripServiceKata\User\User;
use TripServiceKata\User\UserSession;
use TripServiceKata\Exception\UserNotLoggedInException;

class TripService
{
    public function getTripsByUser(User $spiedUser) {
        $loggedInUser = $this->getLoggedInUser();
        if ($loggedInUser != null) {
            $isFriend = $spiedUser->isFriendOf($loggedInUser);
            $tripList = array();
            if ($isFriend) {
                $tripList = $this->loadTripsForUser($spiedUser);
            }
            return $tripList;
        } else {
            throw new UserNotLoggedInException();
        }
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
