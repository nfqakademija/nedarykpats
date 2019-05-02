<?php


namespace App\Security;

use App\Entity\Token;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegistrationHandler extends AbstractController
{
    /**
     * @var \Swift_Mailer
     */
    private $switfMailer;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * RegistrationHandler constructor.
     * @param \Swift_Mailer $swiftMailer
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(\Swift_Mailer $swiftMailer, EntityManagerInterface $entityManager)
    {
        $this->switfMailer = $swiftMailer;
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $recipient
     * @throws \Exception
     */
    public function sendExternalLoginEmail(string $recipient)
    {
        $message = (new \Swift_Message('Prisijungimo nuoroda'))
            ->setFrom('workchase.nfq@gmail.com')
            ->setTo($recipient)
            ->setBody(
                $this->renderView(
                    'emails/externalLogin.html.twig',
                    [
                        'email' => $recipient,
                        'loginUrl' => 'http://127.0.0.1:8000/auth/'.$this->createLoginHash($recipient)
                    ]
                ),
                'text/html'
            );

        $this->switfMailer->send($message);
    }


    /**
     * @param $token
     * @return bool
     */
    public function validateToken($token)
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['token' => $token]);

        if (!$user) {

            $user->setIsConfirmed(true);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return true;
        }
        return false;
    }


    /**
     * @param string $email
     * @throws \Exception
     * @return string
     */
    private function createLoginHash(string $email): string
    {

        $random_prefix = rand();
        $random_suffix = rand();
        $hash = md5($random_prefix.$email.$random_suffix);
        $createDate = new \DateTime('now');

        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            $user = new User();
            $user->setEmail($email)
                ->setRoles(['ROLE_USER'])
                ->setIsConfirmed(false)
                ->setCreatedAt($createDate);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        $token = new Token();
        $token
            ->setHash($hash)
            ->setCreatedAt(new \DateTime('now'))
            ->setExpiresAt($createDate->modify('+ 2 hours'))
            ->setExpired(false)
            ->setUser($user);

        $this->entityManager->persist($token);
        $this->entityManager->flush();

        return $hash;
    }
}
