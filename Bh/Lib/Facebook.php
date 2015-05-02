<?php

namespace BH\Lib;

// {{{ use namespace
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
// }}}

class Facebook
{
    // {{{ variables
    protected $accessToken;
    protected $session;
    protected $clientId;
    protected $clientSecret;
    // }}}

    // {{{ constructor
    public function __construct($clientId, $clientSecret)
    {
        $this->clientId     = $clientId;
        $this->clientSecret = $clientSecret;
        $this->accessToken  = $this->getNewAccessToken($clientId, $clientSecret);
        $this->session      = new FacebookSession($this->accessToken);
        FacebookSession::enableAppSecretProof(false);
    }
    // }}}

    // {{{ getNewAccessToken
    protected function getNewAccessToken($clientId, $clientSecret)
    {
        try{
            $url =  'https://graph.facebook.com/oauth/access_token?' .
                    'client_id=' . $clientId . '&' .
                    'client_secret=' . $clientSecret . '&' .
                    'grant_type=client_credentials';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //to suppress the curl output 
            $response = curl_exec($ch);
            curl_close($ch);

            //response will be access_code=<CODE> so we need to strip off the access_code part at the front/
            $token = "";

            if (
                isset($response)
                && $response !== FALSE
                && substr($response, 0, 13) === "access_token="
            ){
                $token = substr($response, 13);
            }

            return $token;
        }
        catch(\Exception $exc){
            // @todo srsly?
            return "";
        }
    }
    // }}}
    // {{{ request
    public function request($query)
    {
        $graphObject = null;

        if ($this->session) {
            $request        = new FacebookRequest($this->session, 'GET', '/' . $query);
            $graphObject    = $request->execute()->getGraphObject();
        }

        return $graphObject;
    }
    // }}}
}
