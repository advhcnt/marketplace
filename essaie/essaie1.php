                               
<?php
/*---------------------------------------------------------------*/
/*
    Titre : Upload Multi tout type de fichiers + formulaire                                                               
                                                                                                                          
    URL   : https://phpsources.net/code_s.php?id=425
    Auteur           : tex73                                                                                              
    Date édition     : 05 Juil 2008                                                                                       
    Date mise à jour : 10 Aout 2019                                                                                      
    Rapport de la maj:                                                                                                    
    - fonctionnement du code vérifié                                                                                    
    - amélioration du code                                                                                               
    - modification de la description                                                                                      
*/
/*---------------------------------------------------------------*/
 
function FILE_UPLOADER($num_of_uploads=1, $file_types_array=array('jpg',
                                                                  'gif',
                                                                  'png',
                                                                  'mp3',
                                                                  'bmp',
                                                                  'swf',
                                                                  'flv',
                                                                  'mpeg',
                                                                  'jpeg'),
                                      $max_file_size=1048576, $upload_dir=""){
  if(!is_numeric($max_file_size)){
    $max_file_size = 1048576;
  }
  $max_file_size_Mo = $max_file_size/1048576;
  if(!isset($_POST['submitted'])){
    $form = '<form action="" method="post" enctype="multipart/form-data">
    Telechargement de fichier:<input type="hidden" name="submitted"' .
' value="TRUE" id="'.time().'">
                              <input type="hidden" name="MAX_FILE_SIZE" value="'

.$max_file_size.'">';
    for($x=0;$x<$num_of_uploads;$x++){
      $form .= 
'<input type="file" name="file[]"><font color="red">*</font><br /><br />';
    }
    $form .= 
'<input type="submit" value="Telecharger"><br /><font color="red">*</font>
               Type(s) de fichiers autorisés: ';
    $y=count($file_types_array);
  for($x=0;$x<$y;$x++){
      if($x<$y-1){
        $form .= $file_types_array[$x].', ';
      }else{
        $form .= $file_types_array[$x].'.';
      }
    }
    $form .= '</form>';
    echo($form);
  }else{
    foreach($_FILES['file']['error'] as $key => $value){
      if($_FILES['file']['name'][$key]!=""){
        if($value==UPLOAD_ERR_OK){
          $origfilename = $_FILES['file']['name'][$key];
          $filename = explode('.', $_FILES['file']['name'][$key]);
          $filenameext = $filename[count($filename)-1];
          unset($filename[count($filename)-1]);
          $filename = implode('.', $filename);
          $filename = substr($filename, 0, 15).'.'.$filenameext;
          $file_ext_allow = FALSE;
//par mesure de securité on suppose l'extenion du fichier fausse
      //verifions si notre fichier fait partie des types autorisés
      if(false !== ($iClef = array_search($filenameext, $file_types_array))) {
 $file_ext_allow = TRUE;
}
          if($file_ext_allow){
            if($_FILES['file']['size'][$key]<$max_file_size){
              if(move_uploaded_file($_FILES['file']['tmp_name'][$key], 
$upload_dir.$filename)){
                echo('Transfert de fichier effectué avec succès. -
                      <a href="'.$upload_dir.$filename.'" target="_blank">'.
$filename.'</a><br />');
                      
/*evidemment plutot que d'afficher ici le lien vers le fichier uploader
                      sur le serveur vous pouvez proceder à une redirection
 vers
 une autre page*/
              }else{
 echo('Une erreur est survenue lors du transfert de '.'<strong>'.$origfilename.
'</strong><br />');
              }
            }else{
 echo('La taille du fichier '.''.$origfilename.''.' excède les '.
$max_file_size_Mo.' Mo autorisé(s)');
            }
          }else{
 echo('Le fichier '.''.$origfilename.''.
'  a une extension invalide, ERREUR DE TRANSFERT !<br />');
          }
        }else{
          echo('Une erreur est survenue lors du transfert de '.'<strong>'.
$origfilename.'</strong>');
        }
      }
    }
  }
}
 
 
FILE_UPLOADER(10,array('jpg','gif'),1048576,'/');
 
?>


