<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use AppBundle\Exception\InvalidFormException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Util\Codes;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Form\ScoreType;
use AppBundle\Entity\Score;

class GameController extends FOSRestController
{
	/**
	 * Get a game informations and scores identified by an id
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Get a game informations and scores identified by an id",
	 *   output = "AppBundle\Entity\Game",
	 *   statusCodes = {
	 *     200 = "Returned when a game is found",
	 *     404 = "Returned when a game is not found",
	 *   }
	 * )
	 *
	 *
	 * @param int $id the game id
	 *
	 * @return FOS\RestBundle\View\View
	 */
	public function getGameAction($id)
	{
		$game = $this->get('app.game.manager')->get($id);
		if(!$game)
		{
			throw new ResourceNotFoundException('Game not found');
		}

		$view = $this->view($game, 200)
            ->setTemplate("AppBundle:Game:getGame.html.twig")
            ->setTemplateVar('game'); 	
        return $this->handleView($view);
	}

	/**
	 * Get the game list
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Get the game list",
	 *   output = "AppBundle\Entity\Game",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *   }
	 * )
	 *
	 *
	 * @return FOS\RestBundle\View\View
	 */
	public function getGamesAction()
	{
		$game = $this->get('app.game.manager')->all();
		$view = $this->view($game, 200)
            ->setTemplate("AppBundle:Game:getGames.html.twig")
            ->setTemplateVar('games'); 	
        return $this->handleView($view);
	}
}