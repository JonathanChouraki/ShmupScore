<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ScoreType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', 'integer', array("description" => "the score value"))
            ->add('difficulty', 'text', array("description" => "the score difficulty", "required" => false))
            ->add('player', 'entity', array("description" => "the player who has done the score", 'class'=> 'AppBundle:Player', "property" => "name"))
            ->add('game', 'entity', array("description" => "the game for wich the score was done", 'class'=> 'AppBundle:Game', "property" => "name"))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Score'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'score';
    }
}
