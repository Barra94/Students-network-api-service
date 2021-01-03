<?php

namespace App\Models\Email;

use App\Models\Student;
use Illuminate\Support\Facades\Mail;

class EmailSender
{
    /**
     * Send an email to a student
     *
     * @param string $content
     * @param Student $receiver
     * @param string $subject
     */
    public static function sendEmail($receiver, $subject, $content){
        Mail::send([], [], function ($message) use ($receiver, $subject, $content) {
            $message->from('proepmailproviders@gmail.com', 'Item administration');
            $message->sender('proepmailproviders@gmail.com', 'Item administration');
            $message->to($receiver->email);
            $message->subject($subject);
            $message->setBody($content);
        });
    }

    /**
     * Send an email to student with username and password after registration.
     *
     * @param Student $receiver
     * @param string $password
     */
    public static function sendStudentEmailAfterRegistration($receiver, $password){
        $subject = "You have successfully registered at Item." . "\r\n";

        $content = "Dear " . $receiver->surName . "," . "\r\n" . "\r\n";

        $content .= "You have successfully registered at Item." . "\r\n" . "\r\n";

        $content .= "Your username is: " . $receiver->email . "\r\n";
        $content .= "Your Password is: " . $password . "\r\n" . "\r\n";

        $content .= "Kind regards," . "\r\n";
        $content .= "Item team";

        EmailSender::sendEmail($receiver, $subject, $content);
    }

    public static function sendStudentEmailAfterDeletingTheAccount($receiver){
        $subject = "Your account is successfully deleted." . "\r\n";

        $content = "Dear " . $receiver->surName . "," . "\r\n" . "\r\n";

        $content .= "Your account is successfully deleted!" . "\r\n" . "\r\n";

        $content .= "Kind regards," . "\r\n";
        $content .= "Item team";

        EmailSender::sendEmail($receiver, $subject, $content);
    }

    public static function sendStudentEmailWithResetPasswordCode($receiver){
        $resetPasswordUrl = "localhost/?email=" . $receiver->email . "?code=" . $receiver->resetPasswordCode;

        $subject = "Password Reset." . "\r\n";

        $content = "Dear " . $receiver->surName . "," . "\r\n" . "\r\n";

        $content .= "Your password reset code is " . $receiver->resetPasswordCode . " " . "\r\n" . "\r\n";

        $content .= "Click on this link to reset your password." . "\r\n";
        $content .= $resetPasswordUrl . "\r\n" . "\r\n";

        $content .= "Kind regards," . "\r\n";
        $content .= "Item team";

        EmailSender::sendEmail($receiver, $subject, $content);
    }
}