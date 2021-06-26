<?php

namespace App\Services;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * Class GitHubRpoService
 * @package App\Service
 */
class GitHubRpoCLIService
{

    /**
     * @param array $arguments
     * @return array
     */
    public function prepareCLIArguments(array $arguments): ?array
    {
        $filters= [];
        foreach ($arguments as $filter) {
            $parameters = explode(':', $filter);
            isset($parameters[1]) ? $filters[$parameters[0]]=$parameters[1] : [];
        }
        return (!empty($arguments) && empty($filters)) ? null : $filters ;
    }

}
