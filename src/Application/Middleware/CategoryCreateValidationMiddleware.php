<?php

namespace App\Application\Middleware;

use App\Domain\DomainException\DomainInvalidArgumentException;
use App\Domain\Validation\DomainValidationHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpBadRequestException;

class CategoryCreateValidationMiddleware implements Middleware
{
    private DomainValidationHelper $validationHelper;

    public function __construct(DomainValidationHelper $validationHelper)
    {
        $this->validationHelper = $validationHelper;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requiredFields = ['name'];
        $body = $request->getParsedBody() ?? [];
        
        try {
            $this->validationHelper->validateRequiredArguments($requiredFields, $body);
        } catch (DomainInvalidArgumentException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        }
        
        return $handler->handle($request);
    }
}