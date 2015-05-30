<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Score;
use AppBundle\Entity\Player;
use AppBundle\Entity\Game;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadScoreData implements FixtureInterface
{
	static public $score;

    public function load(ObjectManager $manager)
    {
    	$game = new Game();
    	$game->setName('name');
    	$game->setDeveloper('developer');

    	$player = new Player();
    	$player->setName('name');

    	$score = new Score();
    	$score->setValue(1);
    	$score->setPlayer($player);
    	$score->setGame($game);

    	$manager->persist($game);
    	$manager->persist($player);
    	$manager->persist($score);
    	$manager->flush();
    	self::$score = $score;
    }
}