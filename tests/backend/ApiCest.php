<?php

declare(strict_types=1);

namespace Tests\Backend;

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
