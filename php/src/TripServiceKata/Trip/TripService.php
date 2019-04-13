<?php

namespace TripServiceKata\Trip;

use TripServiceKata\User\User;
use TripServiceKata\User\UserSession;
use TripServiceKata\Exception\UserNotLoggedInException;

class TripService
{
    public function getTripsByUser(User $user) {
        $loggedUser = $this->getLoggedInUser();
        if ($loggedUser != null) {
            $isFriend = false;
            foreach ($user->getFriends() as $friend) {
                if ($friend == $loggedUser) {
                    $isFriend = true;
                    break;
                }
            }
            if ($isFriend) {
                return $this->loadTripsOfUser($user);
            }
            return [];
        } else {
            throw new UserNotLoggedInException();
        }
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
