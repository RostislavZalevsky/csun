<?php

namespace App\Data;

use App\Data\Models\Classes;
use App\Data\Models\Semester;
use App\Data\Models\Term;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class CSUN
{
    private const CSUNUrlApi = "https://api.metalab.csun.edu/curriculum/api/2.0";
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getClasses(Term $term = null, Classes $class = null)
    {
        // default
        if (!$term) $term = new Term(Term::getDefaultSemester(), Term::getDefaultYear());
        if (!$class) $class = new Classes('Comp', 110);

        return Cache::remember(self::CSUNUrlApi . $term->getApiQuery() . $class->getApiQuery(), 60 * 60, function () use ($term, $class) { // 1 hour

            $response = $this->client->request('GET', self::CSUNUrlApi . $term->getApiQuery() . $class->getApiQuery());
            if ($response->getStatusCode() != 200) return []; // TODO: need to return with the reason message

            $body = json_decode($response->getBody(), true);
            if (!$body || $body['success'] != true || $body['collection'] != 'classes') return [];

            return $body['classes'];
        });
    }
}

