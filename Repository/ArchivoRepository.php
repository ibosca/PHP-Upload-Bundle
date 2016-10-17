<?php

namespace SisEvo\UploadBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ArchivoRepository extends EntityRepository
{
    public function getFile($idTipo = null, $idAgregado = null, $tipo = null, $categoria = null){
        $query = "SELECT a
                  FROM UploadBundle:Archivo a
                  WHERE a.idTipo = '$idTipo'";
        if($idAgregado != null){
            $query .= " AND a.idAgregado = '$idAgregado' ";
        }
        if($tipo != null){
            $query .= " AND a.tipo = '$tipo'";
        }
        if($categoria != null){
            $query .= " AND a.categoria = '$categoria' ";
        }
        
        
        return $this->getEntityManager()
                ->createQuery($query)
                ->getOneOrNullResult();
    }
    
    public function getFiles($tipo, $categoria){
        $query = "SELECT a
                  FROM UploadBundle:Archivo a
                  WHERE a.tipo = '$tipo'
                  AND a.categoria = '$categoria'
                      
                ";
        return $this->getEntityManager()
                ->createQuery($query)
                ->getResult();
    }
    

}