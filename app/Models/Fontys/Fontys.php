<?php

namespace App\Models\Fontys;

use App\Models\File;
use App\Models\Student;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Client\Response;
use League\CommonMark\Inline\Element\Image;

class Fontys
{
    /**
     * Instance of the API client.
     *
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Fontys constructor.
     *
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $token
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getStudent($token)
    {
        $response = $this->getDecodedResponse('people/me', $token);

        $student = $this->mapToStudent($response, $token);

        return $student;
    }

    /**
     * @param $uri
     * @param $token
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function getDecodedResponse($uri, $token)
    {
        $response = $this->performRequest($uri, $token);

        $decodedResponse = $this->fetchDecodedResponse($response);

        return $decodedResponse;
    }

    /**
     * @param $response
     * @return mixed
     */
    protected function fetchDecodedResponse($response)
    {
        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $uri
     * @param string $token
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function performRequest($uri, $token)
    {
        try {
            $response = $this->client->request('GET', $uri, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                ]
            ]);
        } catch (RequestException $e) {
            // TODO How to handle such an exception? For now just rethrow it.
            throw $e;
        }

        return $response;
    }

    /**
     * @param $response
     * @param $token
     * @return Student
     */
    protected function mapToStudent($response, $token)
    {
        $student = new Student();

        $student->fontysId = $response->id;
        $student->givenName = $response->givenName;
        $student->surName = $response->surName;
        $student->initials = $response->initials;
        $student->displayName = $response->displayName;
        $student->email = $response->mail;
        $student->photo = $response->photo;
        $student->department = $response->department;
        $student->title = $response->title;
        $student->personalTitle = $response->personalTitle;
        $student->employeeId = $response->employeeId;
        $student->fontysToken = $token;
        $student->fontysTokenValidUntil = now()->addSeconds(3600); //TODO Make it real.

        return $student;
    }
}