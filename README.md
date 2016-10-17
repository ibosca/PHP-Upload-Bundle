# PHP-Upload-Bundle
Simple PHP Bundle for Symfony for Upload Files to server and register it on Database.

----> How to use? <------

Este Bundle deberá ser configurado como un servicio en el archivo services.yml de la siguiente manera:

services:
    upload_service:
        class: SisEvo\UploadBundle\Helper\Uploader
        arguments: ['@doctrine.orm.entity_manager', '%kernel.root_dir%']
        
El primer parámetro permitirá relizar las operaciones sobre la base de datos, obteniendo el EntityManager de Doctrine ORM, el segundo parámetro se trata el directorio raíz, a partir de ese, subiremos los archivos en la ruta deseada.

La funcionalidad principal, es decir, lo métodos a utilizar en esta especie de API se encuentran en el directorio Helper. También se puede ver un ejemplo de utilización en el directorio Controller.
