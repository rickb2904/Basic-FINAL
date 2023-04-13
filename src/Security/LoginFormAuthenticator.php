<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\AdherentRepository;
use App\Repository\CoachRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;
    private AdherentRepository $adherentRepository;

    private CoachRepository $coachRepository;

    public function __construct(UrlGeneratorInterface $urlGenerator, AdherentRepository $adherentRepository, CoachRepository $coachRepository)
    {
        $this->urlGenerator = $urlGenerator;
        $this->adherentRepository = $adherentRepository;
        $this->coachRepository = $coachRepository;


    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        if ($this->coachRepository->findBy(['email' => $email])){

            return new Passport(
                new UserBadge($email, function (string $userIdentifier) {
                    return $this->coachRepository->findOneBy(['email' => $userIdentifier]);
                }),
                new PasswordCredentials($request->request->get('password', '')),
                [
                    new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                ]
            );

        }
//elseif($this->adherentRepository->findOneBy(['email' => $email])
        else {

            return new Passport(
                new UserBadge($email, function (string $userIdentifier)  {
                    return $this->adherentRepository->findBy(['email' => $userIdentifier]);
                }),
                new PasswordCredentials($request->request->get('password', '')),
                [
                    new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                ]
            );

        }

    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $user = $token->getUser();

        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        if ($user instanceof User) {
            if (in_array('ROLE_ADHERENTS', $user->getRoles())) {
                return new RedirectResponse($this->urlGenerator->generate('app_adherent_index'));
            } elseif (in_array('ROLE_COACHS', $user->getRoles())) {
                return new RedirectResponse($this->urlGenerator->generate('app_coach_index'));
            }
        }

        // Redirect to a default URL if the user role is not adherent or coach
        return new RedirectResponse($this->urlGenerator->generate('registration'));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
