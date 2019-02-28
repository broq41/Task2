<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository as BaseRepository;

/**
 * Class PersonRepository
 * @package AppBundle\Repository
 */
class PersonRepository extends BaseRepository
{

    /**
     * @param $country
     * @return object|null
     */
    public function findByCountry($country)
    {
        return $this->findOneBy(array('country' => $country));
    }

    /**
     * @param $entity
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($entity){

        if($entity){
            $this->_em->persist($entity);
            $this->_em->flush();
        }

    }

}