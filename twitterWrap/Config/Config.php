<?php
namespace TwitterWrap\Config;

class Config
{
    const API_VERSION = "1.1";
    const BASE_URL = "https://api.twitter.com/";
    const BASE_UPLOAD_URL = "https://upload.twitter.com/";
    const MAX_MEDIA_IDS = 4;
    const OAUTH_AUTHENTICATE = "oauth/authenticate";
    const OAUTH_AUTHORIZE = "oauth/authorize";
    const OAUTH_ACCESS_TOKEN = "oauth/access_token";
    const OAUTH_REQUEST_TOKEN = "oauth/request_token";
    const OAUTH2_INVALIDATE_TOKEN = "oauth2/invalidate_token";
    const OAUTH2_TOKEN = "oauth2/token";

    /**
     * @return string
     */
    public static function getAPIVERSION()
    {
        return self::API_VERSION;
    }

    /**
     * @return string
     */
    public static function getBASEURL()
    {
        return self::BASE_URL;
    }

    /**
     * @return string
     */
    public static function getBASEUPLOADURL()
    {
        return self::BASE_UPLOAD_URL;
    }

    /**
     * @return int
     */
    public static function getMAXMEDIAIDS()
    {
        return self::MAX_MEDIA_IDS;
    }

    /**
     * @return string
     */
    public static function getOAUTHAUTHENTICATE()
    {
        return self::OAUTH_AUTHENTICATE;
    }

    /**
     * @return string
     */
    public static function getOAUTHAUTHORIZE()
    {
        return self::OAUTH_AUTHORIZE;
    }

    /**
     * @return string
     */
    public static function getOAUTHACCESSTOKEN()
    {
        return self::OAUTH_ACCESS_TOKEN;
    }

    /**
     * @return string
     */
    public static function getOAUTHREQUESTTOKEN()
    {
        return self::OAUTH_REQUEST_TOKEN;
    }

    /**
     * @return string
     */
    public static function getOAUTH2INVALIDATETOKEN()
    {
        return self::OAUTH2_INVALIDATE_TOKEN;
    }

    /**
     * @return string
     */
    public static function getOAUTH2TOKEN()
    {
        return self::OAUTH2_TOKEN;
    }
}