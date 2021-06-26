<?php

namespace Tests\Feature;

use App\Services\GitHubRpoCLIService;
use Tests\TestCase;

class GitHubRepoCLIServiceTest extends TestCase
{
    private GitHubRpoCLIService $gitHubRepoService;
    public function setUp(): void
    {
        parent::setUp();
        $this->gitHubRepoService =new GitHubRpoCLIService();
    }


    public function testPrepareCLIArgumentsRightInputs()
    {
        $arguments= ['language:php','per_page:10'];
        $response = $this->gitHubRepoService->prepareCLIArguments($arguments);

        $this->assertIsArray($response);
        $this->assertEquals(['language'=>'php','per_page'=>10], $response);
    }

    public function testPrepareCLIArgumentsWrongInputs()
    {
        $arguments= ['language=php','per_page=10'];
        $response = $this->gitHubRepoService->prepareCLIArguments($arguments);

        $this->assertNull($response);
    }

    public function testPrepareCLIArgumentsWithOutInputs()
    {
        $response = $this->gitHubRepoService->prepareCLIArguments([]);

        $this->assertEmpty($response);
    }

}
