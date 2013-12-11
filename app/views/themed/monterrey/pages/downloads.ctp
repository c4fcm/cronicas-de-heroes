<?php 
$pageTitle = __("page.downloads",true);
$pageDescription = __("page.about.downloads",true);
$pageIcon = 'icon-downloads.gif';
$this->set('title_for_layout', $pageTitle);
echo $this->element('sub_header',array(
    'icon'=>$pageIcon,
    'title'=>$pageTitle,
    'description'=>$pageDescription,
));
?>
