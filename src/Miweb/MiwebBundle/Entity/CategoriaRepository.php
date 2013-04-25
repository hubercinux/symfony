<?php
// src/Miweb/MiwebBundle/Entity/CategoriaRepository.php
namespace Miweb\MiwebBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Miweb\MiwebBundle\Entity\CategoriaRepository ;

class CategoriaRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT c FROM MiwebBundle:Categoria c ORDER BY c.nombre ASC')
            ->getResult();
    }
}