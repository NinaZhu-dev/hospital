<?php

namespace App\Controller;

use App\Entity\Especialidades;
use App\Entity\Servicios;

use App\Repository\EspecialidadesRepository;
use App\Repository\ServiciosRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class HospitalController extends AbstractController{
    
    //Inicio
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

        //contar las veces que se repite una categoria
        $categorias = [];
        foreach ($especialidades as $especialidad){

            $categoria = $especialidad->getCategoria();
            if (!isset($categorias[$categoria])){
                $categorias[$categoria] = 0;
            }
            $categorias[$categoria]++;

        }

        return $this->render('hospital/cuadroMedico.html.twig',[
            'especialidades' => $especialidades,
            'categorias' => $categorias
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
        
        return $this->render('hospital/servicios.html.twig',[
            'servicios' => $servicios
        ]);
    }


}