<?php

namespace App\Controller;

use App\Entity\Medicos;
use App\Form\MedicosType;
use App\Repository\MedicosRepository;

use App\Security\ComprobarPermisos;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/medicos')]
final class MedicosController extends AbstractController{
    
    #[Route('/listado', name: 'app_listado_medicos')]
    public function index(MedicosRepository $medicosRepository): Response
    {
        return $this->render('medicos/listadoMedicos.html.twig', [
            'medicos' => $medicosRepository->findAll(),
        ]);
    }

   
    #[Route('/nuevo', name: 'app_nuevo_medico', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ComprobarPermisos $permiso): Response
    {
        $permisoDenegado = $permiso->comprobarPermisos();
        if($permisoDenegado){
            return $permisoDenegado;
        }

        $medico = new Medicos();
        $form = $this->createForm(MedicosType::class, $medico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($medico);
            $entityManager->flush();

            $this->addFlash('success', 'Médico creado con éxito.');
            return $this->redirectToRoute('app_medicos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('medicos/nuevoMedico.html.twig', [
            'medico' => $medico,
            'form' => $form,
        ]);
    }

    #[Route('/editar/{id}', name: 'app_editar_medico', methods: ['GET', 'POST'])]
    public function edit(Request $request, Medicos $medico, EntityManagerInterface $entityManager, ComprobarPermisos $permiso): Response
    {
        $permisoDenegado = $permiso->comprobarPermisos();
        if($permisoDenegado){
            return $permisoDenegado;
        }

        $form = $this->createForm(MedicosType::class, $medico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Médico actualizado con éxito.');
            return $this->redirectToRoute('app_medicos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('medicos/editarMedico.html.twig', [
            'medico' => $medico,
            'form' => $form,
        ]);
    }

    
}
