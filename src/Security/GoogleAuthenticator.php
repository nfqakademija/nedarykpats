<?php


namespace App\Security;

use App\Entity\User;
use App\Handler\UserCreationHandler;
use bar\foo\baz\ClassConstBowOutTest;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use League\OAuth2\Client\Provider\GoogleUser;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class GoogleAuthenticator extends SocialAuthenticator
{
    /**
     * @var ClientRegistry
     */
    private $clientRegistry;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var UserCreationHandler
     */
    private $userCreationHandler;

    /**
     * GoogleAuthenticator constructor.
     * @param ClientRegistry $clientRegistry
     * @param EntityManagerInterface $em
     * @param RouterInterface $router
     * @param UserCreationHandler $userCreationHandler
     */
    public function __construct(
        ClientRegistry $clientRegistry,
        EntityManagerInterface $em,
        RouterInterface $router,
        UserCreationHandler $userCreationHandler
    ) {
        $this->clientRegistry = $clientRegistry;
        $this->em = $em;
        $this->router = $router;
        $this->userCreationHandler = $userCreationHandler;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request)
    {
        return $request->getPathInfo() == '/connect/google/check' && $request->isMethod('GET');
    }

    /**
     * @param Request $request
     * @return \League\OAuth2\Client\Token\AccessToken|mixed
     */
    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken($this->getGoogleClient());
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return User|object|\Symfony\Component\Security\Core\User\UserInterface|null
     * @throws \Exception
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var GoogleUser $googleUser */
        $googleUser = $this->getGoogleClient()
            ->fetchUserFromToken($credentials);

        $email = $googleUser->getEmail();

        $user = $this->em->getRepository(User::class)
            ->findUserByEmail($email);

        if (!$user) {
            $user = $this->userCreationHandler->createUser(
                $googleUser->getEmail(),
                $googleUser->getName(),
                intval($googleUser->getId()),
                true
            );
        }

        return $user;
    }

    /**
     * @return \KnpU\OAuth2ClientBundle\Client\OAuth2Client
     */
    private function getGoogleClient()
    {
        return $this->clientRegistry
            ->getClient('google');
    }

    /**
     *
     * @param Request $request The request that resulted in an AuthenticationException
     * @param \Symfony\Component\Security\Core\Exception\AuthenticationException $authException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function start(
        Request $request,
        \Symfony\Component\Security\Core\Exception\AuthenticationException $authException = null
    ) {
        return new RedirectResponse('/login');
    }

    /**
     *
     * @param Request $request
     * @param \Symfony\Component\Security\Core\Exception\AuthenticationException $exception
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function onAuthenticationFailure(
        Request $request,
        \Symfony\Component\Security\Core\Exception\AuthenticationException $exception
    ) {
        // TODO: Implement onAuthenticationFailure() method.
    }

    /**
     *
     * @param Request $request
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @param string $providerKey The provider (i.e. firewall) key
     * @return void
     */
    public function onAuthenticationSuccess(
        Request $request,
        \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token,
        $providerKey
    ) {
        // TODO: Implement onAuthenticationSuccess() method.
    }
}
