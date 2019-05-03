<?php
namespace App\Service;

class EmailService
{
    /**
     * @var \Swift_Mailer
     */
    private $switfMailer;

    private $twigTemplating;

    /**
     * EmailService constructor.
     * @param \Swift_Mailer $swiftMailer
     * @param \Twig\Environment $templating
     */
    public function __construct(\Swift_Mailer $swiftMailer, \Twig\Environment $twigTemplating)
    {
        $this->switfMailer = $swiftMailer;
        $this->twigTemplating = $twigTemplating;
    }

    /**
     * @param string $recipient
     * @throws \Exception
     */
    public function sendSingleLoginEmail(string $recipient, string $hash)
    {
        $message = (new \Swift_Message('Vienkartinė prisijungimo nuoroda'))
            ->setFrom('workchase.nfq@gmail.com')
            ->setTo($recipient)
            ->setBody(
                $this->twigTemplating->render(
                    'emails/externalLogin.html.twig',
                    [
                        'email' => $recipient,
                        'loginUrl' => 'http://127.0.0.1:8000/auth/'.$hash
                    ]
                ),
                'text/html'
            );

        $this->switfMailer->send($message);
    }
}
