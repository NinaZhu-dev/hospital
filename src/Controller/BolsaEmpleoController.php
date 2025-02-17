<?php

namespace App\Controller;

use App\Entity\BolsaEmpleo;
use App\Form\BolsaEmpleoType;
use App\Repository\BolsaEmpleoRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class BolsaEmpleoController extends AbstractController{

    //Crear bolsa de empleo
    #[Route('/bolsa_trabajo', name: 'app_bolsa_trabajo', methods: ['GET', 'POST'])]
    public function nuevaBolsaTrabajo(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bolsaEmpleo = new BolsaEmpleo();
        $form = $this->createForm(BolsaEmpleoType::class, $bolsaEmpleo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bolsaEmpleo);
            $entityManager->flush();

            $this->addFlash('success', 'Solicitud enviada con éxito.');
            return $this->redirectToRoute('app_bolsa_trabajo');
        }

        return $this->render('bolsaEmpleo/bolsaTrabajo.html.twig', [
            'bolsa_empleo' => $bolsaEmpleo,
            'form' => $form,
        ]);
    }
    
    //listado empleos para gestionar
    #[Route('/listado_empleos', name: 'app_listado_empleos')]
    public function listadoEmpleo(BolsaEmpleoRepository $BolsaEmpleoRepository): Response
    {
        //Si usuario tipo Administrativo - puede gestionar las solicitudes de trabajo
        $user = $this->getUser();

        if(!in_array('ROLE_ADMINISTRACION', $user->getRoles()))
        {
            $this->addFlash('warning', 'No tiene permisos para gestionar la bolsa de empleos.');
            return $this->redirectToRoute('app_gestion_usuarios');
        }

        $empleos = $BolsaEmpleoRepository->findAll();
        
        return $this->render('bolsaEmpleo/listadoEmpleos.html.twig', [
            'empleos' => $empleos,
        ]);
    }

}