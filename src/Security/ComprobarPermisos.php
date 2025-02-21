<?php

namespace App\Security;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ComprobarPermisos
{
    private Security $security;
    private RouterInterface $router;
    private FlashBagInterface $flashBag;

    public function __construct(Security $security, RouterInterface $router, RequestStack $requestStack)
    {
        $this->security = $security;
        $this->router = $router;
        $this->flashBag = $requestStack->getSession()->getFlashBag();
    }

    public function comprobarPermisos(): ?RedirectResponse
    {
        $user = $this->security->getUser();
        $rolesPermitidos = ['ROLE_ADMINISTRACION', 'ROLE_ADMIN'];

        if (!$user || !array_intersect($rolesPermitidos, $user->getRoles())) {
            
            $this->flashBag->add('warning', 'No tiene permisos.');
            return new RedirectResponse($this->router->generate('app_area_privada'));
        }

        return null;
    }

    public function comprobarPermisosMedico(): ?RedirectResponse
    {
        $user = $this->security->getUser();
        $rolesPermitidos = ['ROLE_MEDICO', 'ROLE_ADMIN'];

        if (!$user || !array_intersect($rolesPermitidos, $user->getRoles())) {
            
            $this->flashBag->add('warning', 'No tiene permisos.');
            return new RedirectResponse($this->router->generate('app_encuestas'));
        }

        return null;
    }
}


?>