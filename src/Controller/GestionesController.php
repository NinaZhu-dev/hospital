<?php

namespace App\Controller;

use App\Entity\Citas;
use App\Form\CitasType;

use App\Entity\BolsaEmpleo;

use App\Repository\CitasRepository;
use App\Repository\BolsaEmpleoRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GestionesController extends AbstractController{

    
    #[Route('/listado_citas', name: 'app_listado_citas')]
    public function listadoCitas(CitasRepository $citasRepository): Response
    {
        $citas = $citasRepository->findBy(['gestionada' => false]);
        
        return $this->render('gestiones/listadoCitas.html.twig', [
            'citas' => $citas,
        ]);
    }

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

        return $this->render('gestiones/editarCita.html.twig', [
            'cita' => $cita,
            'form' => $form,
        ]);

    }
    

    #[Route('/listado_empleos', name: 'app_listado_empleos')]
    public function listadoEmpleo(BolsaEmpleoRepository $BolsaEmpleoRepository): Response
    {
        $empleos = $BolsaEmpleoRepository->findAll();
        
        
        return $this->render('gestiones/listadoEmpleos.html.twig', [
            'empleos' => $empleos,
        ]);
    }

    





}
