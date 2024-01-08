<?php

namespace src\Middlewares\RequestValidations;

use Lukasoppermann\Httpstatus\Httpstatuscodes as Status;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use src\Utils\JsonWriter;
use src\Utils\ParamValidation;

class requestValidation
{
    public function __construct(public array $rules, public string $place)
    {
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        switch ($this->place) {
            case 'body':
                $data = $request->getParsedBody();

                break;
            case 'query':
                $data = $request->getQueryParams();

                break;
        }
        $paramValidation = new ParamValidation();
        foreach ($this->rules as $attr => $rule) {
            $paramValidation->validate($data[$attr] ?? null, $rule, ucfirst($attr));
        }
        if ($paramValidation->failed()) {
            return JsonWriter::error(new Response(), Status::HTTP_BAD_REQUEST, $paramValidation->getErrorMessage());
        }

        return $handler->handle($request);
    }
}
