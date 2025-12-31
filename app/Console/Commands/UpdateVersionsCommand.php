<?php

namespace App\Console\Commands;

use App\Services\GithubVersionService;
use Illuminate\Console\Command;

class UpdateVersionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-versions-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update versions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $api = GithubVersionService::get();
        if (! $api) {
            return;
        }
        $res = collect($api)
            ->map(function ($version) {
                return [
                    'name' => $version['name'],
                    'version' => substr($version['tag_name'], 1),
                    'url' => $version['html_url'],
                    'published_at' => $version['published_at'],
                ];
            });
        $latest = $res->shift();
        $response = $latest;

        file_put_contents(public_path('latest.json'), json_encode($response, JSON_UNESCAPED_SLASHES));
        $this->line(' ');
        $this->info(url('latest.json'));

        $details = collect($api)
            ->map(function ($version) {
                return [
                    'id' => $version['id'],
                    'name' => $version['name'],
                    'version' => substr($version['tag_name'], 1),
                    'url' => $version['html_url'],
                    'body' => $version['body'],
                    'published_at' => $version['published_at'],
                ];
            });
        $latestDetails = $details->shift();
        $detailsResponse = [
            'latest' => $latestDetails,
            'older' => $details,
            'generated' => now()->format('c'),
            'version' => 1,
        ];
        file_put_contents(public_path('versions.json'), json_encode($detailsResponse, JSON_UNESCAPED_SLASHES));

        $this->info('Finished generating version data!');
        $this->line(' ');
        $this->info(url('versions.json'));
    }
}
