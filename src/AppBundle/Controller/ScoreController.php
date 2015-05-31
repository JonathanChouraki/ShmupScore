<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Util\Codes;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Form\ScoreType;
//to be removed
use AppBundle\Entity\Score;

class ScoreController extends FOSRestController
{
	/**
	 * Get a score identified by an id
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Get a score identified by an id",
	 *   output = "AppBundle\Entity\Score",
	 *   statusCodes = {
	 *     200 = "Returned when a score is found",
	 *     404 = "Returned when a score is not found",
	 *   }
	 * )
	 *
	 *
	 * @param int $id the score id
	 *
	 * @return FOS\RestBundle\View\View
	 */
	public function getScoreAction($id)
	{
		$score = $this->getDoctrine()->getRepository("AppBundle:Score")->findOneById($id);
		if(!$score)
		{
			throw new ResourceNotFoundException('Score not found');
		}

		$view = $this->view($score, 200)
            ->setTemplate("AppBundle:Score:getScore.html.twig")
            ->setTemplateVar('score'); 	
        return $this->handleView($view);
	}

	/**
	 * Create a new Score
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Create a new Score",
	 *   input = "AppBundle\Form\ScoreType",
	 *   statusCodes = {
	 *     201 = "Returned when score is successfully created",
	 *     400 = "Returned when the form contains bad parameters"
	 *   }
	 * )
	 *
	 *
	 * @param int $id the score id
	 *
	 */
	public function postScoreAction(Request $request)
	{

		$score = new Score();
		$form = $this->createForm(new ScoreType(), $score);
		$form->bind($request);
        if ($form->isValid()) 
        {
        	$em = $this->getDoctrine()->getManager();
        	$em->persist($score);
        	$em->flush();
            $view = $this->routeRedirectView('get_score', array('id' => $score->getId()), Codes::HTTP_CREATED);
        } 
        else {
            $view = $this->view($form);
            $view->setTemplate('AppBundle:Score:newScore.html.twig');
        }
        return $this->handleView($view);
		
		
	}

	public function newScoreAction()
	{
		$score = new Score();
		$form = $this->createForm(new ScoreType(), $score);
		$view = $this->view($form);
		$view->setTemplateVar("form");
        $view->setTemplate('AppBundle:Score:newScore.html.twig');
        return $this->handleView($view);
	}
}