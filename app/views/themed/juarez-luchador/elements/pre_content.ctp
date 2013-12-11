<?php 
if ($isHomepage) { 
?>  <p>En este año <em><?=$approvedCount?></em> vieron algo y lo reportaron</p>
<?php 
} else { 
    if($this->here=="/pages/donate"){
?>      <p>Únete a los Héroes</p>
<?php 
    }
}
?>