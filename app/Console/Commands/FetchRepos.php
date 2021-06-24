<?php

namespace App\Console\Commands;

use App\Service\GitHubRpoService;
use App\Service\GitHubRpoCLIService;
use Illuminate\Console\Command;
use Storage;
use App\Http\Resources\RepoResource;

class FetchRepos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repos:fetch {filters?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch github repos order by highest stars';


    /**
     * @var GitHubRpoService|GitHubRpoCLIService
     */

    private GitHubRpoService $gitHubRpoService;

    /**
     * @var GitHubRpoCLIService
     */
    private GitHubRpoCLIService $gitHubRpoCLIService;


    /**
     * FetchRepos constructor.
     * @param GitHubRpoCLIService $gitHubRpoService
     */
    public function __construct(GitHubRpoService $gitHubRpoService, GitHubRpoCLIService $gitHubRpoCLIService)
    {
        parent::__construct();

        $this->gitHubRpoService = $gitHubRpoService;
        $this->gitHubRpoCLIService = $gitHubRpoCLIService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filters = $this->gitHubRpoCLIService->prepareCLIArguments($this->argument('filters'));
        if ($filters === null) {
            $this->error('please enter correct filters format ex key:value');
            return ;
        }
        $url = $this->gitHubRpoService->prepareUrl($filters);
        $response = $this->gitHubRpoService->fetchData($url);


        $this->info('The data have been generated to the path storage/app/github Good Luck !');

        Storage::put('github/file.json', json_encode(new RepoResource($response->json()['items'])));
    }
}
