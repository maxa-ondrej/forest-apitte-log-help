<?php

declare(strict_types=1);

namespace App\Module\Backend\V1;

use Apitte\Core\Annotation\Controller\ControllerId;
use Apitte\Core\Annotation\Controller\ControllerPath;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use Apitte\OpenApi\ISchemaBuilder;

/**
 * @ControllerPath("/openapi")
 * @ControllerId("openapi")
 */
class OpenApi extends Base
{
    /** @var ISchemaBuilder */
    private ISchemaBuilder $schemaBuilder;

    public function __construct(ISchemaBuilder $schemaBuilder)
    {
        $this->schemaBuilder = $schemaBuilder;
    }

    /**
     * @Path("/")
     * @Method("GET")
     */
    public function index(ApiRequest $request, ApiResponse $response): ApiResponse
    {
        $openApi = $this->schemaBuilder->build();

        return $response->writeJsonBody($openApi->toArray());
    }
}
