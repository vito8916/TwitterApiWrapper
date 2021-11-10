<?php
namespace TwitterWrap\Connections;

use GuzzleHttp\Client;
use Psr\Http\Message\RequestInterface;
use TwitterWrap\Config\Config;
use TwitterWrap\Credentials\Credentials;
use TwitterWrap\Credentials\UserCredentials;

abstract class Connection
{
    /**
     * Twitter Credentials - Connection type.
     *
     * @var UserCredentials
     */
    protected $credentials;

    /**
     * Guzzle Client to be used during the connection.
     */
    protected $guzzleClient;

    /**
     * A connection. Contains common methods UserConnection!
     *
     * @param Credentials $credentials Twitter Credentials
     */
    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
        $this->guzzleClient = $this->createGuzzleClient(Config::getBASEURL());
    }

    /**
     * Creates a new Guzzle client with Twitter API's base URL and API Version.
     */
    protected function createGuzzleClient($baseUrl)
    {
        //create and return Guzzle client
        return new Client(array(
            'base_uri' => $baseUrl
        ));
    }

    /**
     * Prepend Twitter's API Version to an endpoint.
     */
    protected function prependVersionToEndpoint($endpoint, $version)
    {
        return ($version . '/' . $endpoint);
    }

    /**
     * Constructs an options array that is sent with the request.
     */
    abstract protected function constructRequestOptions($params);

    /**
     * Make a GET request to the endpoint. Also appends query params to the URL.
     */
    public function get($endpoint, $params = null)
    {
        //prepend Twitter's API version to the endpoint
        $endpoint = $this->prependVersionToEndpoint($endpoint, Config::getAPIVERSION());

        //construct an options array to configure the request
        $options = $this->constructRequestOptions($params);

        //make the GET request to the endpoint with the constructed options.
        //return response
        return $this->guzzleClient->get($endpoint, $options);
    }

    public function post($endpoint, $params)
    {
        //prepend Twitter's API version to the endpoint
        $endpoint = $this->prependVersionToEndpoint($endpoint, Config::getAPIVERSION());

        //construct an options array to configure the request
        $options = $this->constructRequestOptions($params);

        //make the GET request to the endpoint with the constructed options.
        //return response
        return $this->guzzleClient->post($endpoint, $options);
    }


    /**
     * Gets the Twitter Credentials - Connection type.
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * Sets the Twitter Credentials - Connection type.
     */
    protected function setCredentials($credentials)
    {
        $this->credentials = $credentials;

        return $this;
    }

    /**
     * Gets the Guzzle Client to be used during the connection.
     */
    public function getGuzzleClient()
    {
        return $this->guzzleClient;
    }

    /**
     * Sets the Guzzle Client to be used during the connection.
     */
    public function setGuzzleClient(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;

        return $this;
    }

}