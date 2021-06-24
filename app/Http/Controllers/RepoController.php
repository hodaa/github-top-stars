<?php

namespace App\Http\Controllers;

use App\Http\Resources\RepoResource;
use App\Service\GitHubRpoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RepoController extends Controller
{
    /**
     * @var GitHubRpoService
     */
    private GitHubRpoService $gitHubRpoService;


    /**
     * RepoController constructor.
     * @param GitHubRpoService $gitHubRpoService
     */
    public function __construct(GitHubRpoService $gitHubRpoService)
    {
        $this->gitHubRpoService = $gitHubRpoService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request  $request): JsonResponse
    {
        $url = $this->gitHubRpoService->prepareUrl($request->input());
        $response = $this->gitHubRpoService->fetchData($url);

        if ($response->failed()) {
            return response()->json(['message'=>'something went wrong']);
        }

        $result= ($response->json() !== null) ? new RepoResource($response->json()['items']) : [];

        return response()->json($result);
    }
}
