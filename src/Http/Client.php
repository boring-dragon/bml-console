<?php

namespace Jinas\BMLConsole\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Cookie\SessionCookieJar;

class Client
{
    protected $client;
    protected $BML_API = 'https://www.bankofmaldives.com.mv/internetbanking/api/';

    public function __construct()
    {
        $jar = new SessionCookieJar('PHPSESSID', true);
        $this->client = new GuzzleClient(['cookies' => $jar]);
    }

    /**
     * post.
     *
     *  Send Post to BML API with array of form params
     *
     *   ['j_username' => $username,'j_password' => $password]
     *
     * @param mixed $params
     * @param mixed $route
     *
     * @return array
     */
    public function post(array $params, string $route): array
    {
        try {
            $response = $this->client->request('POST', $this->BML_API.$route, [
                'form_params' => $params,
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            throw new \Exception('Error communicating with API');
        }
    }

    /**
     * get.
     *
     *  Send Get request to BML API
     *
     * @param mixed $route
     */
    public function get(string $route)
    {
        $response = $this->client->request('GET', $this->BML_API.$route);
        $rawresponse = json_decode($response->getBody(), true);

        return $rawresponse['payload'];
    }
}
