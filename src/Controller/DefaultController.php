<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Footer;

use App\Repository\MenuRepository;
use App\Repository\FooterRepository;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class DefaultController extends AbstractController
{
	
	#[Route("/menu", name: "menu")]
	public function menu(MenuRepository $menuRepo)
	{
		$menus = $menuRepo->findby(
			[],
			['orden' => 'ASC']
		);	
		return $this->render('comunes/_menu.html.twig',[
			'menus' => $menus,
		]);
	}


	#[Route("/footer", name: "footer")]
	public function footer(FooterRepository $footerRepo)
	{
		$footers = $footerRepo->findby(
			[],
			['fila' => 'ASC', 'columna' => 'ASC']
		);		
		return $this->render('comunes/_footer.html.twig',[
			'footers' => $footers
		]);
	}
    
	


}
