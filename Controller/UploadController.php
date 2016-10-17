<?php

namespace SisEvo\UploadBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use SisEvo\UploadBundle\Entity\Archivo;
use SisEvo\UploadBundle\Form\ArchivoType;

class UploadController extends Controller {

    /**
     * @Route("/file_upload/" , name = "file_upload")
     */
    public function probarAction() {
        $request = $this->getRequest();

        $file = $this->get('upload_service');
        $formulario = $this->createForm(new ArchivoType());

        $formulario->handleRequest($request);

        if ($formulario->isValid()) {
            $data = $formulario->getData();
            $fileUploaded = $data->getFile();
            //$path = $this->get('kernel')->getRootDir() . '/../web/uploads';

            $archivo = new Archivo('1', '1', 'MyType', 'MyCategory');

            $resultat = $file->upload($fileUploaded, $archivo);

            if ($resultat == 1) {
                echo "ARXIU PUJAT CORRECTAMENT!";
            } else {
                echo "ERROR!!";
            }
        }
        return $this->render("upload/prova.html.twig"
                        , array("formulario" => $formulario->createView())
        );
    }
    
    
    /**
     * @Route("/file_listar/" , name = "file_listar")
     */
    public function listarAction() {
        
        $em = $this->getDoctrine()->getManager();
        $arxius = $em->getRepository('UploadBundle:Archivo')
                    ->findAll();
        
        return $this->render("upload/file_delete.html.twig"
                        , array("arxius" => $arxius
                    ));
        
    }
    
    
    /**
     * @Route("/file_delete/{id}" , name = "file_delete")
     */
    public function deleteAction(Archivo $id) {
        $file = $this->get('upload_service');
        $resultat = $file->delete($id);
        if($resultat == 1){
            echo "ARXIU ELIMINAT CORRECTAMENT!";
            return $this->redirect($this->generateUrl('file_listar'));
        } else {
            echo "ERROR!";
        }
    }
    
    
    

}
