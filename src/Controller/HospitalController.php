<?php

namespace App\Controller;

use App\Entity\Especialidades;
use App\Entity\Servicios;
use App\Entity\Citas;
use App\Entity\BolsaEmpleo;
use App\Entity\TipoEncuesta;
use App\Entity\Preguntas;
use App\Entity\Respuestas;

use App\Form\CitasType;
use App\Form\BolsaEmpleoType;

use App\Repository\EspecialidadesRepository;
use App\Repository\ServiciosRepository;
use App\Repository\CitasRepository;
use App\Repository\BolsaEmpleoRepository;
use App\Repository\TipoEncuestaRepository;
use App\Repository\PreguntasRepository;

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

            $this->addFlash('success', 'Cita enviada con éxito.');
            return $this->redirectToRoute('app_cita_previa');
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

            $this->addFlash('success', 'Solicitud enviada con éxito.');
            return $this->redirectToRoute('app_bolsa_trabajo');
        }

        return $this->render('hospital/bolsaTrabajo.html.twig', [
            'bolsa_empleo' => $bolsaEmpleo,
            'form' => $form,
        ]);
    }

    //TipoEncuesta
    #[Route('/encuestas', name: 'app_encuestas')]
    public function listarEncuestas(TipoEncuestaRepository $encuestaRepo): Response
    {   
        $encuestas = $encuestaRepo ->findAll();
        
        return $this->render('hospital/encuestas.html.twig',[
            'encuestas' => $encuestas
        ]);
    }

    // Realizar encuesta elegida
    #[Route('/encuestas/{id}', name: 'app_realizar_encuesta')]
    public function realizarEncuesta(int $id, TipoEncuestaRepository $encuestaRepo, PreguntasRepository $preguntasRepo ): Response
    {   
        $encuesta = $encuestaRepo->find($id);
        $preguntas = $preguntasRepo->findBy(['encuesta' => $encuesta->getId()]);

        if (empty($preguntas)){
            return $this->render('hospital/index.html.twig');
        }

        return $this->render('hospital/iniciarEncuesta.html.twig',[
            'preguntas' => $preguntas,
            'encuesta' => $encuesta
        ]);
    }

    //Guardar respuesta encuesta
    #[Route('/encuestas/{id}/enviar', name: 'app_encuesta_enviada', methods: ['POST'])]
    public function encuestaEnviada(Preguntas $preguntas, Request $request, EntityManagerInterface $em): Response
    {
        $datos = $request ->request->all();
        $fechaEncuesta = new \DateTime($request->request->get('fechaActual'));
        
        //Comprobar los datos recibidos
        foreach ($datos as $key => $valor)
        {
            if (strpos($key, 'pregunta_') === 0) 
            {
                $preguntaId = str_replace('pregunta_', '', $key);
                $pregunta = $em->getRepository(Preguntas::class)->find($preguntaId);

                if ($pregunta) 
                {
                    $respuesta = new Respuestas();
                    $respuesta->setPregunta($pregunta);
                    $respuesta->setFecha($fechaEncuesta);

                    //Si usuario logueado obtener user sino anonima
                    $respuesta->setUsuario($this->getUser() ?? null);

                    // Determinar tipo de respuesta
                    if ($pregunta->getTipo() === 'valoracion') 
                    {
                        $respuesta->setValoracion((int) $valor);
                    } elseif ($pregunta->getTipo() === 'booleano')
                    {   
                        if ($valor === 'SI'){
                            $respuesta->setValoracion(1);
                        }
                        else{
                            $respuesta->setValoracion(0);
                        }
                        
                    }
                    elseif ($pregunta->getTipo() === 'texto'){
                        //si son comentarios
                        $respuesta->setComentario($valor);
                    }

                    $em->persist($respuesta);
                }
            }
        }

        $em->flush();

        $this->addFlash('success', 'Encuesta enviada con éxito.');

        return $this->redirectToRoute('app_encuestas');
    }

}