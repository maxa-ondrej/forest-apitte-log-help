<?php

declare(strict_types=1);

namespace App\Module\Backend\V1;

use Apitte\Core\Annotation\Controller\ControllerId;
use Apitte\Core\Annotation\Controller\ControllerPath;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Annotation\Controller\Tag;
use Apitte\Core\Annotation\Controller\RequestParameter;
use Apitte\Core\Annotation\Controller\RequestParameters;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use App\Domain\Backend\Facade\Users as UsersFacade;
use App\Domain\Backend\Request\LoginUserReqDto;
use App\Domain\Backend\Request\RegisterUserReqDto;
use App\Model\Exception\Runtime\User\EmailTakenException;
use App\Model\Exception\Runtime\User\UsernameTakenException;
use Nette\Http\IResponse;
use Nette\Utils\Json;
use Tracy\Debugger;
use Tracy\ILogger;

/**
 * @ControllerPath("/user")
 * @ControllerId("user")
 */
final class User extends Base
{
    private UsersFacade $usersFacade;

    public function __construct(UsersFacade $usersFacade)
    {
        $this->usersFacade = $usersFacade;
    }

    /**
     * @Path("/register")
     * @Method("POST")
     * @Tag(value="App\Domain\Api\Request\RegisterUserReqDto")
     */
    public function register(ApiRequest $request, ApiResponse $response): ApiResponse
    {
        try {
            $this->usersFacade->create($request->getParsedBody());

            return $response->withStatus(IResponse::S201_CREATED)
                ->withHeader('Content-Type', 'application/json')
                ->writeBody(Json::encode([
                    'message' => 'success',
                ]));
        } catch (\Doctrine\DBAL\Exception\DriverException $e) {
            throw \Apitte\Core\Exception\Api\ServerErrorException::create()
                ->withMessage('Could not create user.')
                ->withPrevious($e);
        } catch (UsernameTakenException|EmailTakenException $e) {
            throw \Apitte\Core\Exception\Api\ClientErrorException::create()
                ->withCode(IResponse::S409_CONFLICT)
                ->withPrevious($e);
        }
    }

    /**
     * @Path("/login")
     * @Method("POST")
     * @Tag(value="App\Domain\Api\Request\LoginUserReqDto")
     */
    public function login(ApiRequest $request, ApiResponse $response): ApiResponse
    {
        /** @var LoginUserReqDto $dto */
        $dto = $request->getParsedBody();

        try {
            $this->usersFacade->findOne($dto);

            return $response->withStatus(IResponse::S200_OK)
                ->withHeader('Content-Type', 'application/json');
        } catch (\App\Model\Exception\Runtime\Database\EntityNotFoundException $e) {
            throw \Apitte\Core\Exception\Api\ClientErrorException::create()
                ->withMessage('Username or password is incorrect.')
                ->withCode(IResponse::S401_UNAUTHORIZED);
        }
    }
}
