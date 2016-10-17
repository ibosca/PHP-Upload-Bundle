<?php

namespace SisEvo\UploadBundle\Helper;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use SisEvo\UploadBundle\Entity\Archivo;
use SisEvo\UploadBundle\Entity\ArchivoBorrado;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


class Uploader {

    private $fs; 
    private $em;
    private $rootDir;

    public function __construct($em, $rootDir) {
        $this->em = $em;
        $this->rootDir = $rootDir;
        $this->fs = new Filesystem;
    }

    public function upload(UploadedFile $uploadedFile, Archivo $archivo) {

        //$rootDir = '/var/www/html/evoIsaac/app/../web/uploads/{tipo}/{category}';
        $path = $this->rootDir . '/../web/uploads/' . $archivo->getTipo() . '/' . $archivo->getCategoria();

        //COMPLETAEM EL OBJECTE
        $archivo->setFechaGuardado(new \DateTime());
        $archivo->setPath($path);
        $archivo->setNombre($uploadedFile->getClientOriginalName());

        $registro = $this->register($archivo);

        if ($registro == 1) {
            $name = $uploadedFile->getClientOriginalName();

            $uploadedFile->move($path, $name);
            $this->fs->mkdir($path .'/borrados', 0777); //EN PROVES
            unset($uploadedFile);
            return 1;
        } else {
            return 0;
        }
    }

    public function delete(Archivo $archivo) {

        //$rootDir = '/var/www/html/evoIsaac/app/../web/uploads/{tipo}/{category}/borrados';
        $path = $this->rootDir . '/../web/uploads/' . $archivo->getTipo() . '/' . $archivo->getCategoria() . '/borrados';

        $pathVell = $archivo->getPath();
        //ACTUALITZEM OBJECTE
        $archivo->setPath($path);

        $registro = $this->deleteRegister($archivo);

        if ($registro == 1) {

            \rename($pathVell . '/' . $archivo->getNombre(), $path . '/' . $archivo->getNombre());

            return 1;
        } else {
            return 0;
        }
    }
    
    public function download(Archivo $archivo){
        //Generem la ruta al arxiu
        $filePath = $archivo->getPath().'/'.$archivo->getNombre();
        
        //Comprovem que el arxiu existeix
        $fs = new FileSystem();
        if (!$fs->exists($filePath)) {
            throw $this->createNotFoundException();
        }
        
        //Prepara la resposta
        $response = new BinaryFileResponse($filePath);
        $response->trustXSendfileTypeHeader();
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $archivo->getNombre(),
            iconv('UTF-8', 'ASCII//TRANSLIT', $archivo->getNombre())
        );

        return $response;
    }
    
    public function getFileIfExists(Archivo $archivo){
        $id_tipo = $archivo->getIdTipo();
        $id_agregado = $archivo->getIdAgregado();
        $tipo = $archivo->getTipo();
        $categoria = $archivo->getCategoria();
        
        $archivoCompleto = $this->em->getRepository('UploadBundle:Archivo')
                ->getFile($id_tipo, $id_agregado, $tipo, $categoria);
        
        if(!empty($archivoCompleto)){
            return $archivoCompleto;
        } else {
            return $archivo;
        }
        
    }
    
    private function deleteRegister(Archivo $archivo){
        
        $archivoBorrado = new ArchivoBorrado($archivo->getIdTipo(), $archivo->getIdAgregado(), $archivo->getTipo(), $archivo->getCategoria(), $archivo->getNombre(), $archivo->getPath(), new \DateTime());
        $this->em->persist($archivoBorrado);
        $this->em->remove($archivo);
        $this->em->flush();
        
        return 1;
        
    }

    private function register(Archivo $archivo) {

        $this->em->persist($archivo);
        $this->em->flush();
        return 1;
    }
    
    
    
    

}
