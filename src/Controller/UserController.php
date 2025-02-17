<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController{

    #[Route('/gestion_usuarios', name: 'app_gestion_usuarios')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('usuarios/gestionUsuarios.html.twig');
    }

    #[Route('/mi_perfil', name: 'app_mi_perfil')]
    public function miPerfil(Security $security, UserRepository $userRepository): Response
    {
        $usuario = $security->getUser();
        $id = $usuario->getId();

        $usuarioBD = $userRepository ->find($id);
        
        if ($usuarioBD)
        {
            return $this->render('usuarios/miPerfil.html.twig', [
                'usuario' => $usuario
            ]);
        }
        
        return $this->render('usuarios/gestionUsuarios.html.twig');
        
    }

    #[Route('/listado_usuarios', name: 'app_listado_usuarios')]
    public function listado(UserRepository $userRepository): Response
    {
        $usuarios = $userRepository->findAll();
        
        return $this->render('usuarios/listadoUsuarios.html.twig', [
            'usuarios' => $usuarios,
        ]);
    }

    #[Route('/nuevo_usuario', name: 'app_nuevo_usuario', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        //Si usuario tipo Admin - puede crear usuarios, editar, etc
        $user = $this->getUser();

        if(!in_array('ROLE_ADMIN', $user->getRoles()))
        {
            $this->addFlash('warning', 'No tiene permisos para gestionar usuarios.');
            return $this->redirectToRoute('app_gestion_usuarios');
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Encriptar contraseña antes de guardar en la BD
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Usuario creado con éxito.');
            return $this->redirectToRoute('app_listado_usuarios', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('usuarios/nuevoUsuario.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/editar_usuario/{id}/', name: 'app_editar_usuario', methods: ['GET', 'POST'])]
    public function editar(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        //Si usuario tipo Admin - puede crear usuarios, editar, etc
        $user = $this->getUser();

        if(!in_array('ROLE_ADMIN', $user->getRoles()))
        {
            $this->addFlash('warning', 'No tiene permisos para gestionar usuarios.');
            return $this->redirectToRoute('app_gestion_usuarios');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Usuario editado con éxito.');
            return $this->redirectToRoute('app_listado_usuarios', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('usuarios/editarUsuario.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }





}
