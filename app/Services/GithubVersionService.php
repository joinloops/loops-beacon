<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GithubVersionService
{
    public static function get()
    {
        $api = 'https://api.github.com/repos/joinloops/loops-server/releases?per_page=6';
        $res = Http::withToken(config('api.gh_token'))->acceptJson()->get($api);

        if (! $res->ok()) {
            return false;
        }

        $json = $res->json();

        return $json;
    }
}
