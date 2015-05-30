<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Score
 *
 * @ORM\Table(name="ss_score")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ScoreRepository")
 */
class Score
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="value", type="integer")
     * @Assert\NotBlank(message="Score value cannot be left blank")
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="mode", type="string", length=255, nullable=true)
     */
    private $mode;

    /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="scores")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Score must have a player")
     **/
    private $player;

    /**
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="scores")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Score must have a game")
     **/
    private $game;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return Score
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set mode
     *
     * @param string $mode
     * @return Score
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Get mode
     *
     * @return string 
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set player
     *
     * @param \AppBundle\Entity\Player $player
     * @return Score
     */
    public function setPlayer(\AppBundle\Entity\Player $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \AppBundle\Entity\Player 
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set game
     *
     * @param \AppBundle\Entity\Game $game
     * @return Score
     */
    public function setGame(\AppBundle\Entity\Game $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \AppBundle\Entity\Game 
     */
    public function getGame()
    {
        return $this->game;
    }
}
