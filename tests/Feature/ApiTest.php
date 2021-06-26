<?php

namespace Tests\Feature;

use App\Services\GitHubRpoService;
use Tests\TestCase;
use Illuminate\Http\Client\Response;
use GuzzleHttp\Psr7\Response as clientResponse;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testApiRepos()
    {
        $mock = $this->mock(GitHubRpoService::class);

        $mock->shouldReceive('prepareUrl');

        $mock->shouldReceive('fetchData')
            ->andReturn(new Response(new clientResponse(
                200,
                [],
                json_encode(['items'=>[[
                    'id'=>    1,
                    'name'=>   'repo_1',
                    'url' => 'www.github.com',
                    'owner' =>['url'=>'www.github.com_o'],
                    'description'=> 'desc',
                    'forks'=> 1,
                    'watchers'=> 1,
                    'language' => 1,
                    'stargazers_count' => 1,
                    'created_at' => 1,
                    'updated_at' => 1,
                ],
                [
                    'id'=>    2,
                    'name'=>   'repo_2',
                    'url' => 'www.github.com2',
                    'owner' => ['url'=>'www.github.com_o2'],
                    'description'=> 'desc',
                    'forks'=> 1,
                    'watchers'=> 1,
                    'language' => 1,
                    'stargazers_count' => 1,
                    'created_at' => 1,
                    'updated_at' => 1,
                ]
                ]])
            )));


        $response = $this->get('/api/v1/repos');
        $response->assertStatus(200);
        $this->assertCount(2, $response->json());
    }
}
