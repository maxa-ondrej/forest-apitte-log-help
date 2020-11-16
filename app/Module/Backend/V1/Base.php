<?php

declare(strict_types=1);

namespace App\Module\Backend\V1;

use Apitte\Core\Annotation\Controller\GroupId;
use Apitte\Core\Annotation\Controller\GroupPath;
use App\Module\Backend\Base as MainBase;

/**
 * @GroupPath("/v1")
 * @GroupId("v1")
 */
abstract class Base extends MainBase
{
}
