<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Util\Codes;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Form\ScoreType;

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

	public function postScoreAction()
	{

	}
}