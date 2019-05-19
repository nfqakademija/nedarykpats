<?php
namespace App\Handler;

class EmailHandler
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
        $message = (new \Swift_Message('Prisijungimo nuoroda'))
            ->setTo($recipient)
            ->setBody(
                $this->twigTemplating->render(
                    'email_templates/confirmation_single_login.html.twig',
                    [
                        'email' => $recipient,
                        'loginUrl' => $hash
                    ]
                ),
                'text/html'
            );

        $this->switfMailer->send($message);
    }

    /**
     * @param string $recipient
     * @throws \Exception
     */
    public function sendRegistrationConfirmation(string $recipient, string $hash)
    {
        $message = (new \Swift_Message('Registracija sėkminga!'))
            ->setTo($recipient)
            ->setBody(
                $this->twigTemplating->render(
                    'email_templates/confirmation.html.twig',
                    [
                        'email' => $recipient,
                        'loginUrl' => $hash
                    ]
                ),
                'text/html'
            );

        $this->switfMailer->send($message);
    }

    /**
     * @param string $recipient
     * @throws \Exception
     */
    public function sendAdvertConfirmationWithSingleLoginUrl(string $recipient, string $hash)
    {
        $message = (new \Swift_Message('Patvirtinkite skelbimo patalpinimą'))
            ->setTo($recipient)
            ->setBody(
                $this->twigTemplating->render(
                    'email_templates/confirmation_advert.html.twig',
                    [
                        'email' => $recipient,
                        'loginUrl' => $hash
                    ]
                ),
                'text/html'
            );

        $this->switfMailer->send($message);
    }

    /**
     * @param string $recipient
     * @throws \Exception
     */
    public function sendOfferConfirmationWithSingleLoginUrl(string $recipient, string $hash)
    {
        $message = (new \Swift_Message('Patvirtinkite pasiūlymo patalpinimą'))
            ->setTo($recipient)
            ->setBody(
                $this->twigTemplating->render(
                    'email_templates/confirmation_offer.html.twig',
                    [
                        'email' => $recipient,
                        'loginUrl' => $hash
                    ]
                ),
                'text/html'
            );

        $this->switfMailer->send($message);
    }

    /**
     * @param string $recipient
     * @throws \Exception
     */
    public function sendEmailPasswordWasChanged(string $recipient, string $hash)
    {
        $message = (new \Swift_Message('Slaptažodis buvo pakeistas'))
            ->setTo($recipient)
            ->setBody(
                $this->twigTemplating->render(
                    'email_templates/password_was_changed.html.twig',
                    [
                        'email' => $recipient,
                        'loginUrl' => $hash
                    ]
                ),
                'text/html'
            );

        $this->switfMailer->send($message);
    }
}
