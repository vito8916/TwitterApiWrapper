<?php
namespace TwitterWrap;

use ErrorException;
use TwitterWrap\Connections\UserConnection;
use TwitterWrap\Credentials\Credentials;
use TwitterWrap\Credentials\UserCredentials;

class Client
{
    /**
     * Twitter Credentials.
     *
     * @var UserCredentials
     */
    private $credentials;

    /**
     * The current connection in use.
     *
     * @var UserConnection
     */
    private $connection;

    /**
     * Constructs a new Twitter Client object.
     *
     * $credentials should be an instance of UserCredentials if you want to make calls on user's behalf.
     *
     * @param Credentials $credentials Twitter credentials
     *
     */
    public function __construct(Credentials $credentials)
    {
        //check if $credentials is a subclass of Credentials
        $this->credentials = $credentials;
    }

    /**
     * Checks the type of $credentials (if App or User) and returns a new connection instance accordingly.
     *
     * @return UserConnection Type of connection to Twitter.
     */
    public function connect()
    {
        //set User specific connection
        $this->connection = new UserConnection($this->credentials);

        return $this->connection;
    }

    /**
     * Gets the Twitter Credentials.
     *
     * @return UserCredentials
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * Sets the Twitter Credentials.
     *
     * @param UserCredentials $credentials the credentials
     *
     * @return self
     */
    public function setCredentials($credentials)
    {
        $this->credentials = $credentials;

        return $this;
    }

    /**
     * Gets the current connection in use.
     *
     * @return UserConnection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Sets the current connection in use.
     *
     * @param UserConnection $connection the connection
     *
     * @return self
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;

        return $this;
    }
}