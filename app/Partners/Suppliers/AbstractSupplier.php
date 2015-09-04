<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 27/08/15
 * Time: 15:39
 */
namespace  App\Partners\Suppliers;
class AbstractSupplier {

    public function ftp_open()
    {
        // Connexion
        $conn_id = ftp_connect($this->FTP_HOST, 21, 90) ;
        if(!$conn_id){
            return -1 ;
        }
        // Authentification
        $login_result = ftp_login($conn_id, $this->FTP_USER, $this->FTP_PASSWORD) ;
        if(!$login_result) {
            return -2 ;
        }
        // Mode passif
        ftp_pasv($conn_id, true) ;
        return $conn_id ;
    }

   public function ftp_load()
    {
        // connexion
        $conn_id = $this->ftp_open() ;
        $fileName = $this->referenceList['CATALOG']['file_name'] ;
        if(!$conn_id)
            return -1 ;
        // upload a file
/*        if (ftp_put ( $conn_id, $this->referenceList['CATALOG']['remote_dir'].$fileName, '/home/walid/Desktop/catalogue_CdiscountPro.CSV', FTP_BINARY )) {
            echo "successfully uploaded $fileName\n";
        } else {
            echo "There was a problem while uploading $fileName\n";
        }*/

        if(ftp_get($conn_id, $this->referenceList['CATALOG']['local_dir'] . $fileName, $this->referenceList['CATALOG']['remote_dir'] . $fileName, FTP_BINARY)){
            echo "Le fichier  a été écris avec succès\n";
        } else {
            echo "Il y a un problème\n";
        }
        ftp_close($conn_id) ;
        //chmod($this->referenceList['CATALOG']['local_dir'] . $fileName, 0777);

        return 1 ;
    }

    public function putFileTest(){
        $conn_id = $this->ftp_open() ;
        $fileName = $this->referenceList['CATALOG']['file_name'] ;
        if(!$conn_id)
            return -1 ;
        // upload a file
        if (ftp_put ( $conn_id, $this->referenceList['CATALOG']['remote_dir'].$fileName, '/home/walid/Desktop/catalogue_CdiscountPro.CSV', FTP_BINARY )) {
            return "successfully uploaded $fileName\n";
        } else {
            return "There was a problem while uploading $fileName\n";
        }

    }

}