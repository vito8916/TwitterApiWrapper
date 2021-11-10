<?php
namespace TwitterWrap\Connections;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use TwitterWrap\Config\Config;
use TwitterWrap\Credentials\UserCredentials;

class UserConnection extends Connection
{

    protected $credentials;
    protected $guzzleClient;

    /**
     * A user connection to Twitter.
     *
     * @param UserCredentials $credentials Twitter API credentials
     */
    public function __construct(UserCredentials $credentials)
    {
        parent::__construct($credentials);
    }

    /**
     * Constructs an options array that is sent with the request.
     */
    protected function constructRequestOptions($params, $client = null)
    {
        //empty options array
        $options = array();

        //this is a User connection, use Oauth1 tokens.
        $oauth = new Oauth1(array(
            'consumer_key'    => $this->credentials->getConsumerKey(),
            'consumer_secret' => $this->credentials->getConsumerSecret(),
            'token'           => $this->credentials->getAccessToken(),
            'token_secret'    => $this->credentials->getAccessTokenSecret()
        ));

        //attach oauth to Guzzle client
        $stack = HandlerStack::create();
        $stack->push($oauth);
        $options['handler'] = $stack;

        //if query parameters not supplied, continue.
        if(!is_null($params))
        {
            //Add query parameters to options.
            $options['query'] = $params;
        }

        //Set the "auth" request option to "oauth" to sign using oauth.
        $options['auth'] = 'oauth';

        //return constructed options
        return $options;
    }

    /**
     * Get a request token and configures a Twitter authorization URL that the
     * user will be redirected to for authentication.
     *
     * Then returns the prepared Twitter authorization URL.
     *
     * @return string authentication URL
     */
    public function getRedirectUrlForAuth()
    {
        //Oauth1 plugin to get access tokens!
        $oauth = new Oauth1(array(
            'consumer_key'    => $this->credentials->getConsumerKey(),
            'consumer_secret' => $this->credentials->getConsumerSecret(),
            'token'           => '',
            'token_secret'    => '',
            'callback'        => $this->credentials->getCallbackUrl()
        ));

        //Oauth1 plugin to get access tokens!
        $stack = HandlerStack::create();
        $stack->push($oauth);

        //obtain request token for the authorization popup.
        $requestTokenResponse = $this->guzzleClient->post(
            Config::getOAUTHREQUESTTOKEN(),
            array(
                'handler' => $stack,
                'auth' => 'oauth'
            )
        );

        //Parse the response from Twitter
        $oauthToken = array();
        parse_str($requestTokenResponse->getBody(), $oauthToken);

        //build the query parameters
        $params = http_build_query(array(
            'oauth_token' => $oauthToken['oauth_token']
        ));

        //return the redirect URL the user should be redirected to.
        return (Config::getBASEURL() . Config::getOAUTHAUTHENTICATE() . '?' . $params);
    }

    /**
     * Get Access tokens from the user in exchange for oauth_token and oauth_verifier and return
     * them.
     *
     * @param  string $oauthToken
     * @param  string $oauthVerifier
     * @return array contains 'oauth_token', 'oauth_token_secret', 'user_id' and 'screen_name'.
     */
    public function getAccessToken($oauthToken, $oauthVerifier)
    {
        //Oauth1 plugin to get access tokens!
        $oauth = new Oauth1(array(
            'consumer_key'    => $this->credentials->getConsumerKey(),
            'consumer_secret' => $this->credentials->getConsumerSecret(),
            'token'           => $oauthToken,
            'token_secret'    => '',
            'verifier'        => $oauthVerifier
        ));

        //attach oauth to request
        $stack = HandlerStack::create();
        $stack->push($oauth);

        //POST to 'oauth/access_token' - get access tokens
        $response = null;
        try {
            $accessTokenResponse = $this->guzzleClient->post(
                Config::getOAUTHACCESSTOKEN(),
                array(
                    'handler' => $stack,
                    'auth' => 'oauth'
                )
            );

            //handle response
            $response = array();
            parse_str($accessTokenResponse->getBody(), $response);

            //set access tokens
            $this->credentials
                ->setAccessToken($response['oauth_token'])
                ->setAccessTokenSecret($response['oauth_token_secret']);

        } catch (ClientException $e) {
            if($e->getCode() !== 200) {
                return [
                    'oauth_token' => null,
                    'oauth_token_secret' => null,
                    'user_id' => null,
                    'screen_name' => null,
                ]; //contains 'oauth_token', 'oauth_token_secret', 'user_id' and 'screen_name'
            }
        }

        return $response; //contains 'oauth_token', 'oauth_token_secret', 'user_id' and 'screen_name'

    }

}