<?php

namespace AppBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use AppBundle\Form\ScoreType;
use AppBundle\Exception\InvalidFormException;

class Manager implements ManagerInterface
{
	private $om;
    private $entityClass;
    private $repository;
    private $formFactory;
    private $formType;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory, $formType = null)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
        $this->formType = $formType;
    }

	public function get($id)
	{
		return $this->repository->findOneById($id);
	}

	public function all($limit = 10, $offset = 0)
	{
		/** 
		 * @todo
		 */
		return $this->repository->findAll();
	}

	public function post(array $parameters)
	{
		return $this->processForm(new $this->entityClass, $parameters);
	}
	
	private function processForm($entityClass, array $parameters)
	{
		$form = $this->formFactory->create($this->formType, $entityClass);
		$form->submit($parameters);
		if(!$form->isValid())
		{
			throw new InvalidFormException("Invalid submitted data", $form);
		}
		else
		{
			$this->om->persist($entityClass);
			$this->om->flush();
			return $entityClass;
		}
	}
}