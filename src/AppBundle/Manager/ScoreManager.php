<?php

namespace AppBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use AppBundle\Entity\Score;
use AppBundle\Form\ScoreType;
use AppBundle\Exception\InvalidFormException;


class ScoreManager implements ManagerInterface
{
	private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
    }

	public function get($id)
	{
		return $this->repository->findOneById($id);
	}

	public function all($limit = 5, $offset = 0)
	{
		/** 
		 * @todo
		 */
		//return $this->repository->findAllByIdLimitOffset($id);
	}

	public function post(array $parameters)
	{
		return $this->processForm(new Score(), $parameters);
	}
	
	private function processForm(Score $score, array $parameters)
	{
		$form = $this->formFactory->create(new ScoreType(), $score);
		$form->submit($parameters);
		if($form->isValid())
		{
			$this->om->persist($score);
			$this->om->flush();
			return $score;
		}
		else
			throw new InvalidFormException("Invalid submitted data", $form);
	}

}