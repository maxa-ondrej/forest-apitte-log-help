<?php

declare(strict_types=1);

namespace Tests\Api;

use ApiTester;

class ApiCest
{
    public function tryApi(ApiTester $I): void
    {
        $I->sendGet('/');
        $I->seeResponseCodeIs(401);
        $I->seeResponseIsJson();
    }
}
