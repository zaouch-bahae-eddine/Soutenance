<?php

namespace App\Security;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    /**
     * @var UtilisateurRepository
     */
    private $utilisateurRepository;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UtilisateurRepository $utilisateurRepository, RouterInterface $router, UserPasswordEncoderInterface $encoder)
    {
        $this->utilisateurRepository = $utilisateurRepository;
        $this->router = $router;
        $this->encoder = $encoder;
    }

    public function supports(Request $request)
    {
         return
             $request->attributes->get('_route') == "show_login"
             && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'email' => $request->request->get('login_form')['email'],
            'password' => $request->request->get('login_form')['password']
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );
        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        //return null;
        return $this->utilisateurRepository->findOneBy(['email' => $credentials['email']]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
            return $this->encoder->isPasswordValid($user, $credentials['password']);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->router->generate('home_page'));
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('show_login');
    }

}
