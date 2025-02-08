<?php

namespace App\Controller;

use App\Entity\Especialidades;
use App\Entity\Servicios;
use App\Entity\Citas;
use App\Entity\BolsaEmpleo;

use App\Form\CitasType;
use App\Form\BolsaEmpleoType;

use App\Repository\EspecialidadesRepository;
use App\Repository\ServiciosRepository;
use App\Repository\CitasRepository;
use App\Repository\BolsaEmpleoRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class HospitalController extends AbstractController{
    
    #[Route('/', name: 'app_hospital')]
    public function index(): Response
    {
        return $this->render('hospital/index.html.twig');
    }

    // Listar especialidades
    #[Route('/cuadro_medico', name: 'app_cuadro_medico')]
    public function listarEspecialidades(EspecialidadesRepository $especialidadRepo): Response
    {   
        $especialidades = $especialidadRepo ->findby(
            [],
            ['categoria' => 'ASC']
        );
        return $this->render('hospital/cuadroMedico.html.twig',[
            'especialidades' => $especialidades
        ]);
    }

    // Listar medico especialidad elegida
    #[Route('/cuadro_medico/{id}', name: 'app_medico_especialidad')]
    public function listarMedicoEspecialidades(int $id, EspecialidadesRepository $especialidadRepo): Response
    {   
        $especialidad = $especialidadRepo ->find($id);

        if(! $especialidad){
            throw $this -> createNotFoundException('Especialidad no encontrada');
        }

        $medicos = $especialidad -> getMedicos();

        if (empty($medicos)){
            return $this->render('hospital/index.html.twig');
        }

        return $this->render('hospital/medicos.html.twig',[
            'especialidad' => $especialidad,
            'medicos' => $medicos
        ]);
    }



    // Listar servicios
    #[Route('/servicios', name: 'app_servicios')]
    public function listarServicios(ServiciosRepository $serviciosRepo, EspecialidadesRepository $especialidadesRepo): Response
    {   
        $servicios = $serviciosRepo ->findAll();
    
        $especialidades = []; 
        $medicos = []; 
        
        foreach ($servicios as $servicio) {
            $especialidad = $especialidadesRepo->find($servicio->getEspecialidad()->getId());
    
            if ($especialidad)
            {
                $especialidades[$servicio->getId()] = $especialidad;
                $medicos[$servicio->getId()] = $especialidad->getMedicos();
            }
        }
        
        
        return $this->render('hospital/servicios.html.twig',[
            'servicios' => $servicios,
            'especialidades' =>  $especialidades,
            'medicos' => $medicos
        ]);
    }

    // Cita previa
    #[Route('/cita_previa', name: 'app_cita_previa', methods: ['GET', 'POST'])]
    public function nuevaCitaPrevia(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cita = new Citas();
        $form = $this->createForm(CitasType::class, $cita);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cita);
            $entityManager->flush();

            return $this->redirectToRoute('hospital/index.html.twig');
        }

        return $this->render('hospital/citaPrevia.html.twig', [
            'cita' => $cita,
            'form' => $form,
        ]);
    }

    //Bolsa de empleo
    #[Route('/bolsa_trabajo', name: 'app_bolsa_trabajo', methods: ['GET', 'POST'])]
    public function nuevaBolsaTrabajo(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bolsaEmpleo = new BolsaEmpleo();
        $form = $this->createForm(BolsaEmpleoType::class, $bolsaEmpleo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bolsaEmpleo);
            $entityManager->flush();

            return $this->redirectToRoute('hospital/index.html.twig');
        }

        return $this->render('hospital/bolsaTrabajo.html.twig', [
            'bolsa_empleo' => $bolsaEmpleo,
            'form' => $form,
        ]);
    }

    


}
