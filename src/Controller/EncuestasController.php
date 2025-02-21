<?php

namespace App\Controller;

use App\Entity\TipoEncuesta;
use App\Entity\Preguntas;
use App\Entity\Respuestas;

use App\Repository\TipoEncuestaRepository;
use App\Repository\PreguntasRepository;
use App\Repository\RespuestasRepository;

use App\Security\ComprobarPermisos;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class EncuestasController extends AbstractController{
    
    //TipoEncuesta
    #[Route('/encuestas', name: 'app_encuestas')]
    public function listarEncuestas(TipoEncuestaRepository $encuestaRepo): Response
    {   
        $encuestas = $encuestaRepo ->findAll();
        
        return $this->render('encuestas/encuestas.html.twig',[
            'encuestas' => $encuestas,
            'user' => 'user'
        ]);
    }

    // Realizar encuesta elegida
    #[Route('/encuestas/{id}', name: 'app_realizar_encuesta')]
    public function realizarEncuesta(int $id, TipoEncuestaRepository $encuestaRepo, PreguntasRepository $preguntasRepo, ComprobarPermisos $permiso): Response
    {   
        $encuesta = $encuestaRepo->find($id);

        if ($encuesta->getId() == 3)  
        {
            $permisoDenegado = $permiso->comprobarPermisosMedico();
            if($permisoDenegado){
                return $permisoDenegado;
            }
            
        }
        
        $preguntas = $preguntasRepo->findBy(['encuesta' => $encuesta->getId()]);

        if (empty($preguntas)){
            return $this->render('hospital/index.html.twig');
        }

        return $this->render('encuestas/iniciarEncuesta.html.twig',[
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

    //Listado encuestas completadas
    #[Route('/listado_encuestas', name: 'app_listado_encuestas')]
    public function listadoEncuestas(RespuestasRepository $respuestaRepository, ComprobarPermisos $permiso): Response
    {
        $permisoDenegado = $permiso->comprobarPermisos();
        if($permisoDenegado){
            return $permisoDenegado;
        }

        $encuestas = $respuestaRepository->resultadoEncuestas();
        
        return $this->render('encuestas/listadoEncuestas.html.twig', [
            'encuestas' => $encuestas,
        ]);
    }


}