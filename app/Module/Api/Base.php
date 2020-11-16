<?php

declare(strict_types=1);

namespace App\Module\Api;

use Apitte\Core\Annotation\Controller\GroupId;
use Apitte\Core\Annotation\Controller\GroupPath;
use Apitte\Core\UI\Controller\IController;

/**
 * @GroupPath("/api")
 * @GroupId("api")
 */
abstract class Base implements IController
{
}
