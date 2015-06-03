<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\Utils\JsonTest;
use AppBundle\DataFixtures\ORM\LoadScoreData;

class ScoreControllerTest extends JsonTest
{
	public function testGetJson()
	{
		$this->loadFixtures(array('AppBundle\DataFixtures\ORM\LoadScoreData'));
        $score = LoadScoreData::$score;
        $route =  $this->getUrl('get_score', array('id'=> $score->getId(), '_format' => 'json'));
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
        $this->assertTrue(isset($content['player']));
        $this->assertTrue(isset($content['game']));
        $this->assertTrue(isset($content['value']));
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

	public function testPostJson()
	{
		$this->loadFixtures(array('AppBundle\DataFixtures\ORM\LoadScoreData'));
		$route =  $this->getUrl('post_score', array('_format' => 'json'));
	    $this->client->request(
	        'POST',
	        $route,
	        array(),
	        array(),
	        array('CONTENT_TYPE' => 'application/json'),
	        '{"score":{"value": 1, "player":1, "game":1}}'
	    );
	    $this->assertJsonResponse($this->client->getResponse(), 201, false);
	}

	public function testPostReturn400WhenBadParametersJson()
	{
		$this->loadFixtures(array('AppBundle\DataFixtures\ORM\LoadScoreData'));
		$route =  $this->getUrl('post_score', array('_format' => 'json'));
	    $this->client->request(
	        'POST',
	        $route,
	        array(),
	        array(),
	        array('CONTENT_TYPE' => 'application/json'),
	        '{"score":{"value": a, "player":1, "game":1}}'
	    );
	    $this->assertJsonResponse($this->client->getResponse(), 400);
	}

	public function testPostReturn400WhenPlayerNotFoundJson()
	{
		$this->loadFixtures(array('AppBundle\DataFixtures\ORM\LoadScoreData'));
		$route =  $this->getUrl('post_score', array('_format' => 'json'));
	    $this->client->request(
	        'POST',
	        $route,
	        array(),
	        array(),
	        array('CONTENT_TYPE' => 'application/json'),
	        '{"score":{"value": a, "player":999, "game":1}}'
	    );
	    $this->assertJsonResponse($this->client->getResponse(), 400);
	}

	public function testPostReturn400WhenGameNotFoundJson()
	{
		$this->loadFixtures(array('AppBundle\DataFixtures\ORM\LoadScoreData'));
		$route =  $this->getUrl('post_score', array('_format' => 'json'));
	    $this->client->request(
	        'POST',
	        $route,
	        array(),
	        array(),
	        array('CONTENT_TYPE' => 'application/json'),
	        '{"score":{"value": a, "player":1, "game":999}}'
	    );
	    $this->assertJsonResponse($this->client->getResponse(), 400);
	}

	public function testNewJson()
	{
		$route =  $this->getUrl('new_score', array('_format' => 'json'));
	    $this->client->request(
	        'GET',
	        $route,
	        array(),
	        array(),
	        array('CONTENT_TYPE' => 'application/json')
	    );
	    $this->assertJsonResponse($this->client->getResponse(), 200);
	}
}