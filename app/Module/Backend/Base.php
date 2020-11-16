<?php

declare(strict_types=1);

namespace App\Module\Backend;

use Apitte\Core\Annotation\Controller\GroupId;
use Apitte\Core\Annotation\Controller\GroupPath;
use Apitte\Core\UI\Controller\IController;

/**
 * @GroupPath("/backend")
 * @GroupId("backend")
 */
abstract class Base implements IController
{
}
