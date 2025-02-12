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
        return $this->render('gestiones/gestionUsuarios.html.twig');
    }

    #[Route('/mi_perfil', name: 'app_mi_perfil')]
    public function miPerfil(Security $security, UserRepository $userRepository): Response
    {
        $usuario = $security->getUser();
        $id = $usuario->getId();

        $usuarioBD = $userRepository ->find($id);
        
        if ($usuarioBD)
        {
            return $this->render('gestiones/miPerfil.html.twig', [
                'usuario' => $usuario
            ]);
        }
        
        return $this->render('gestiones/gestionUsuarios.html.twig');
        
    }

    #[Route('/listado_usuarios', name: 'app_listado_usuarios')]
    public function listado(UserRepository $userRepository): Response
    {
        $usuarios = $userRepository->findAll();
        
        return $this->render('gestiones/listadoUsuarios.html.twig', [
            'usuarios' => $usuarios,
        ]);
    }

    #[Route('/nuevo_usuario', name: 'app_nuevo_usuario', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
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

        return $this->render('gestiones/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/editar_usuario/{id}/', name: 'app_editar_usuario', methods: ['GET', 'POST'])]
    public function editar(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Usuario editado con éxito.');
            return $this->redirectToRoute('app_listado_usuarios', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('gestiones/editarUsuario.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'app_eliminar_usuario', methods: ['GET','POST'])]
    // public function eliminar(Request $request, User $user, EntityManagerInterface $entityManager): Response
    // {
    //     $token = $request->get('_token');

    //     if (!$this->isCsrfTokenValid('delete'.$user->getId(), $token)) {
    //         $this->addFlash('danger', 'Token CSRF inválido. No se eliminó el usuario.');
    //         return $this->redirectToRoute('app_listado_usuarios');
    //     }

    //     try {
    //         $entityManager->remove($user);
    //         $entityManager->flush();

    //         $this->addFlash('warning', 'Usuario eliminado.');
    //     } catch (\Exception $e) {
    //         $this->addFlash('danger', 'Error al eliminar el usuario: ' . $e->getMessage());
    //     }

    //     return $this->redirectToRoute('app_listado_usuarios', [], Response::HTTP_SEE_OTHER);
    // }






}
