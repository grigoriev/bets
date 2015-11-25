<?php

namespace bets\utils;

class URL
{
    const INDEX = '/';
    const LOGIN = '/login';

    const BETS_API_TEST = '/bets/api/test';

    const BETS_API_USER_AUTHENTICATE = '/bets/api/user/authenticate/';
    const BETS_API_USER_FIND_USERNAME = '/bets/api/user/find/username/';
    const BETS_API_USER_LOGOUT = '/bets/api/user/logout/';
    const BETS_API_USER_NEW = '/bets/api/user/new/';

    const BETS_API_USER_SESSION_NEW = '/bets/api/user/session/new/';
    const BETS_API_USER_SESSION_FIND_UUID = '/bets/api/user/session/find/uuid/';
    const BETS_API_USER_SESSION_FIND_USERNAME = '/bets/api/user/session/find/username/';
}