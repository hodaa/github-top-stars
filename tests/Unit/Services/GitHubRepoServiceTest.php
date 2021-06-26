<?php

namespace Tests\Feature;

use App\Services\GitHubRpoService;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class GitHubRepoServiceTest extends TestCase
{
    /**
     * @var GitHubRpoService
     */
    private GitHubRpoService $gitHubRepoService;


    public function setUp(): void
    {
        parent::setUp();
        $this->gitHubRepoService = new GitHubRpoService();
    }



    public function testPrepareUrlEmptyData()
    {
        $response= $this->gitHubRepoService->prepareUrl([]);
        $this->assertEquals(config('github.url').'?q=created:>2019-01-10', $response);
    }


    public function testPrepareUrlWithData()
    {
        $response= $this->gitHubRepoService->prepareUrl(['per_page'=>'10']);
        $this->assertEquals(config('github.url').'?q=created:>2019-01-10&per_page=10', $response);

        $response= $this->gitHubRepoService->prepareUrl(['per_page'=>'10','language'=>'php']);
        $this->assertEquals(config('github.url').'?q=language:php&per_page=10', $response);
    }

    public function testFetchDataWithEmptyResponse()
    {
        HTTP::fake();
        $response = $this->gitHubRepoService->fetchData(config('github.url'));
        $this->assertEquals($response->status(), 200);
        $this->assertInstanceOf(\Illuminate\Http\Client\Response::class, $response);
        $this->assertEmpty($response->body());
        

    }

}
