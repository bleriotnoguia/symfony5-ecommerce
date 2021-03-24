<?php

namespace App\Classe;

use \Mailjet\Client;
use \Mailjet\Resources;

class Mail
{
    private $api_key = '5059764d82d5c4b97dba51047130575e';
    private $api_key_secret = '686d62e5c117c771b702d65e91cfc628';

    public function send($to_email, $to_name, $subject, $content)
    {
        $mj = new Client($this->api_key, $this->api_key_secret, true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "nstevebleriot@yahoo.fr",
                        'Name' => "Fonyshop"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 2689548,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'variables' => [
                        'content' => $content
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}

?>