<?php

namespace App\Service;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * Class GitHubRpoService
 * @package App\Service
 */
class GitHubRpoService
{
    public const  QUALIFIERS = [
         'created',
         'pushed',
         'language',
        ];

    public const  LIMITERS = [
        'per_page',
        'order',
        'sort',

    ];

    /**
     * @param array $filters
     * @return String
     */
    public function prepareUrl(array $filters): String
    {
        $url = config('github.url').'?q=';
        $qualifiers = '';
        $limiters= '';

        foreach ($filters as $key=>$value) {
            if (in_array($key, self::QUALIFIERS)) {
                $qualifiers.= $key.':'.$value.'+';
            }
            if (in_array($key, self::LIMITERS)) {
                $limiters.= $key.'='.$value.'&';
            }
        }

        $limiters =  rtrim($limiters, '&');
        $qualifiers = rtrim($qualifiers, '+');

        $url = $qualifiers ? $url.$qualifiers : $url.'created:>'. config('github.created_at');

        return $limiters ? $url .'&'. $limiters : $url;
    }

    

    /**
     * @param string $url
     * @return PromiseInterface|Response
     */
    public function fetchData(string $url)
    {
        return Http::withHeaders([
            'Authorization' => 'token '. config('github.token'),
        ])->timeout(10, 3)->get($url);
    }
}
