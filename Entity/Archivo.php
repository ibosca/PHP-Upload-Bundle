<?php

namespace SisEvo\UploadBundle\Entity;

//Aquest use per a que trobe la classe File de Symfony, sense ell, buscarà la classe UploadBundle\Entity\File i provocarà un error!!!
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="SisEvo\UploadBundle\Repository\ArchivoRepository")
 */
class Archivo {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idTipo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idAgregado;

    /**
     * @ORM\Column(type="string")
     */
    private $tipo;

    /**
     * @ORM\Column(type="string")
     */
    private $categoria;

    /**
     * @ORM\Column(type="string")
     */
    private $nombre;

    /**
     * @ORM\Column(type="string")
     */
    private $path;

    /**
     * @ORM\Column(type="date")
     */
    private $fechaGuardado;
    
    
    function __construct($idTipo = null, $idAgregado = null, $tipo = null, $categoria = null) {
        $this->idTipo = $idTipo;
        $this->idAgregado = $idAgregado;
        $this->tipo = $tipo;
        $this->categoria = $categoria;
    }

    /**
     * @var File
     *
     * @Assert\File(
     *     maxSize = "6M",
     *     mimeTypes = {"application/pdf", "application/x-pdf",
     *                  "application/x-rar-compressed", "application/octet-stream", "vnd.rar", "application/x-rar",
     *                  "text/csv", "application/csv", "text/comma-separated-values", "application/excel", "application/vnd.ms-excel", "application/vnd.msexcel", "text/anytext", "text/plain"},
     *     maxSizeMessage = "El arxiu que intentes pujar sobrepassa el limit de 6MB.",
     *     mimeTypesMessage = "El tipus d'arxiu seleccionat no està permitit." 
     * )
     */
    protected $file;

    function getFile() {
        return $this->file;
    }

    function setFile(File $file) {
        $this->file = $file;
    }

    function getId() {
        return $this->id;
    }

    function getIdTipo() {
        return $this->idTipo;
    }

    function getIdAgregado() {
        return $this->idAgregado;
    }

    function getIdMultiple() {
        return $this->idMultiple;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getCategoria() {
        return $this->categoria;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getPath() {
        return $this->path;
    }

    function getFechaGuardado() {
        return $this->fechaGuardado;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdTipo($idTipo) {
        $this->idTipo = $idTipo;
    }

    function setIdAgregado($idAgregado) {
        $this->idAgregado = $idAgregado;
    }

    function setIdMultiple($idMultiple) {
        $this->idMultiple = $idMultiple;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setPath($path) {
        $this->path = $path;
    }

    function setFechaGuardado($fechaGuardado) {
        $this->fechaGuardado = $fechaGuardado;
    }



}
