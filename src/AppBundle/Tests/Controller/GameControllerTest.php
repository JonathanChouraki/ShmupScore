<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\Utils\JsonTest;
use AppBundle\DataFixtures\ORM\LoadScoreData;

class GameControllerTest extends JsonTest
{
	public function testGetJson()
	{
		$this->loadFixtures(array('AppBundle\DataFixtures\ORM\LoadScoreData'));
        $score = LoadScoreData::$score;
        $route =  $this->getUrl('get_game', array('id'=> $score->getGame()->getId(), '_format' => 'json'));
      	$this->client->request(
        	'GET',
	        $route,
	        array(),
	        array(),
	        array('CONTENT_TYPE' => 'application/json')
	    );
	    $response = $this->client->getResponse();
	    $this->assertJsonResponse($response); 
	    $content = json_decode($response->getContent(), true);
        $this->assertTrue(isset($content['id']));
        $this->assertTrue(isset($content['name']));
        $this->assertTrue(isset($content['developer']));
        $this->assertTrue(isset($content['scores']));
	}

	public function testGetReturn404WhenScoreNotFoundJson()
	{
		$this->loadFixtures(array());
        $score = LoadScoreData::$score;
        $route =  $this->getUrl('get_score', array('id'=> 1, '_format' => 'json'));
      	$this->client->request(
        	'GET',
	        $route,
	        array(),
	        array(),
	        array('CONTENT_TYPE' => 'application/json')
	    );
	    $this->assertJsonResponse($this->client->getResponse(), 404); 
	}

	public function testGetListJson()
	{
		$this->loadFixtures(array('AppBundle\DataFixtures\ORM\LoadScoreData'));
        $score = LoadScoreData::$score;
        $route =  $this->getUrl('get_games', array('_format' => 'json'));
      	$this->client->request(
        	'GET',
	        $route,
	        array(),
	        array(),
	        array('CONTENT_TYPE' => 'application/json')
	    );
	    $response = $this->client->getResponse();
	    $this->assertJsonResponse($response); 
	    $content = json_decode($response->getContent(), true);
	    $this->assertTrue(is_array($content));
	    $content = $content[0];
        $this->assertTrue(isset($content['id']));
        $this->assertTrue(isset($content['name']));
        $this->assertTrue(isset($content['developer']));
        $this->assertTrue(isset($content['scores']));
	}
}