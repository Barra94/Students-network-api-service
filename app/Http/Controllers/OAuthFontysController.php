<?php

namespace App\Http\Controllers;

use App\Models\Email\EmailSender;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Fontys\Fontys;
use App\Models\Fontys\AccessToken;
use \GuzzleHttp\Exception\GuzzleException;

class OAuthFontysController
{
    /**
     * @param AccessToken $accessToken
     * @param Fontys $fontys
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function create(AccessToken $accessToken, Fontys $fontys)
    {
        if (request()->has('code')) {

            try {
                $payload = $accessToken->requestFromCode(request('code'));
                $token = $payload->access_token;

                $student = $fontys->getStudent($token);

                $random_password = Str::random(16);
                $student->password = Hash::make($random_password);
                //$student->password = Hash::make('123456');
                $student->save();

                EmailSender::sendStudentEmailAfterRegistration($student, $random_password);

                $token = $student->createToken('web-application');

                return redirect()->to('/?token=' . $token->plainTextToken);
            }
            catch (GuzzleException $e){
                return response()->json(["message" => "student not added successfully."], 400);
                //TODO redirect to front-end real url with an error message as parameter.
            }
            catch (\Exception $e) {
                return response()->json(["message" => "student not added successfully."], 400);
                //TODO redirect to front-end real url with an error message as parameter.
            }
        }
    }

    public function signup(AccessToken $accessToken)
    {
        return redirect()->to($accessToken->authenticationUrl());
    }
}