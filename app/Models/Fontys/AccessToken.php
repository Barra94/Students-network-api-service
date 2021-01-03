<?php

namespace App\Models\Fontys;

class AccessToken
{
    /**
     * Get the authentication url.
     *
     * @return string
     */
    public function authenticationUrl()
    {
        $url = $this->getOAuthURL() . 'connect/authorize?' . http_build_query([
                'client_id' => config('app.fontys.Client_Id'),
                'scope' => 'fhict fhict_personal openid profile email roles',
                'redirect_uri' => route('fontys-redirect'),
                'response_type' => 'code',
            ]);

        return $url;
    }

    /**
     * Request a new access token from a authentication code.
     *
     * @param string $code
     * @return \stdClass mixed
     */
    public function requestFromCode($code)
    {
        $payload = $this->buildRequestPayload($code);

        $curl = $this->setupCurlRequest($payload);

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }

    /**
     * Setup the curl request.
     *
     * @param array $payload
     * @return resource
     */
    protected function setupCurlRequest($payload)
    {
        $curl = curl_init($this->getOAuthURL() . 'connect/token');

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($payload));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        return $curl;
    }

    /**
     * Build the payload for an access token request.
     *
     * @param string $code
     * @return array
     */
    protected function buildRequestPayload($code)
    {
        return [
            'code'          => $code,
            'client_id'     => config('app.fontys.Client_Id'),
            'client_secret' => config('app.fontys.Client_Secret'),
            'redirect_uri'  => route('fontys-redirect'),
            'grant_type'    => 'authorization_code',
        ];
    }

    /**
     * Get the url to the OAuth server.
     *
     * @return string
     */
    protected function getOAuthURL()
    {
        return config('app.fontys.Uri');
    }
}