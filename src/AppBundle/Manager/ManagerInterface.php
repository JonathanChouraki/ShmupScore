<?php

namespace AppBundle\Manager;

interface ManagerInterface
{
	/**
     * Get a entity given the identifier
     *
     *
     * @param mixed $id
     *
     * @return Entity
     */
    public function get($id);

    /**
     * Get a list of entities
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0);

    /**
     * Creates a new entity
     *
     * @param array $parameters
     *
     * @return Entity
     */
    public function post(array $parameters);
}