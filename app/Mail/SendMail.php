<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Setting;
use App\Repositories\Setting\SettingInterface;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $subject;
    public $iscc;

    public function __construct($data, $subject, $iscc)
    {
        $this->data = $data;
        $this->subject = $subject;
        $this->iscc = $iscc;
    }

    public function build()
    {
        $getSettingMail = Setting::where('id', 4)->first()->settings;
        $getSettingMailAddress = json_decode($getSettingMail)->email_address;

        if($this->iscc == true){
            $exForCC = explode(' | ', $getSettingMailAddress);
        } else {
            $exForCC = [];
        }


        //dd($this->data[0]['site_id']);
        //dd($this->data['message']);
        $address = 'noreply@mtsbd.net';
        $subject = $this->subject;
        $name = 'MTS App Notification';
        $messages = $this->data;

        $file_name = $subject;
        $mail_path= public_path().'/'.$subject.'.xlsx';

        return $this->view('email', compact('messages'))
                    //->attach($mail_path,['as'=>$file_name])
                    ->from($address, $name)
                    ->cc($exForCC, $name)
                    //->replyTo($address, $name)
                    ->subject($subject);
    }
}
