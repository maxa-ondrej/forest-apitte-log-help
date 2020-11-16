<?php

declare(strict_types=1);

namespace Tests\Backend;

use ApiTester;

class UserCest
{
    public function tryRegister(ApiTester $I): void
    {
        $I->wantToTest('User registration.');
        $I->sendGet('/v1/user/register', [
            'username' => 'MyName',
            'email' => 'email@gmail.com',
            'password' => 'password',
        ]);
        $I->seeResponseCodeIs(405);
        $I->seeResponseEquals(
            '{"status":"error","code":405,"message":"Method \"GET\" is not allowed for endpoint \"/backend/v1/user/register\"."}',
        );
        $I->seeResponseIsJson();

        $I->sendPost('/v1/user/register', [
            'username' => 'MyName2',
            'email' => 'email@gmail.com',
            'password' => 'password',
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }
}
