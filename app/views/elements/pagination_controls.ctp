<p class="hr-pagination">
<?php
if($paginator->hasPrev()){
    echo " ".$paginator->first('<<');
    echo " ".$paginator->prev('<');
}
echo " ".$paginator->numbers()." "; 
if($paginator->hasNext()){
    echo " ".$paginator->next('>');
    echo " ".$paginator->last('>>');
}
?>
</p>

