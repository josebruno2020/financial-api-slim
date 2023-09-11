<?php

namespace App\Application\Middleware;

use App\Application\Helper\RequestHelper;
use App\Domain\DomainException\DomainInvalidArgumentException;
use App\Domain\Group\GroupRepository;
use App\Domain\Validation\DomainValidationHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpBadRequestException;

readonly class MovementGroupValidationMiddleware implements Middleware
{

    public function __construct(
        private DomainValidationHelper $validationHelper,
        private GroupRepository        $groupRepository
    )
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requiredFields = ['group_id'];
        $params = $request->getQueryParams() ?? [];

        try {
            $this->validationHelper->validateRequiredArguments($requiredFields, $params);
        } catch (DomainInvalidArgumentException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        }

        $userId = RequestHelper::getUserIdFromRequest($request);
        $usersInGroup = $this->groupRepository->listUsersGroup($params['group_id']);

        foreach ($usersInGroup as $groupUser) {
            if ($groupUser->getId() === $userId) {
                return $handler->handle($request);

            }
        }
        
        throw new HttpBadRequestException($request, "Ação não permitida a não membros do grupo");
    }
}