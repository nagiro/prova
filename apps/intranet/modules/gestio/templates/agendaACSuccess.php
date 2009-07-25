<?PHP
   echo "asdfasdfasdfsdfdfsdfasdfsdafsdaf"; 
   echo '<ul>';
   foreach($AGENDA as $AT):
      echo '<li>'.$AT->getNom().'</li>';
   endforeach;
   echo '</ul>';

?>