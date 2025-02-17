<?php

namespace App\Controller;

use App\Entity\Citas;
use App\Form\CitasType;
use App\Repository\CitasRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class CitasController extends AbstractController{

    // Crear cita previa
    #[Route('/cita_previa', name: 'app_cita_previa', methods: ['GET', 'POST'])]
    public function nuevaCitaPrevia(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cita = new Citas();
        $form = $this->createForm(CitasType::class, $cita);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cita);
            $entityManager->flush();

            $this->addFlash('success', 'Cita enviada con éxito.');
            return $this->redirectToRoute('app_cita_previa');
        }

        return $this->render('citas/citaPrevia.html.twig', [
            'cita' => $cita,
            'form' => $form,
        ]);
    }

    //Listado citas para gestionar
    #[Route('/listado_citas', name: 'app_listado_citas')]
    public function listadoCitas(CitasRepository $citasRepository): Response
    {
        //Si usuario tipo Medico - puede gestionar las citas
        $user = $this->getUser();

        if(!in_array('ROLE_MEDICO', $user->getRoles()))
        {
            $this->addFlash('warning', 'No tiene permisos para gestionar citas medicas.');
            return $this->redirectToRoute('app_gestion_usuarios');
        }
            
        $citas = $citasRepository->findBy(['gestionada' => false]);
        
        return $this->render('citas/listadoCitas.html.twig', [
            'citas' => $citas,
        ]);
    }

    //Editar cita - añadir fecha, etc
    #[Route('/listado_citas/{id}/', name: 'app_editar_cita', methods: ['GET', 'POST'])]
    public function editarCita(Request $request, Citas $cita, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CitasType::class, $cita, ['is_edit' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Cita editada/gestionada con éxito.');
            return $this->redirectToRoute('app_listado_citas', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('citas/editarCita.html.twig', [
            'cita' => $cita,
            'form' => $form,
        ]);

    }
    

}