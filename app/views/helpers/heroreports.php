<?php

class HeroreportsHelper extends AppHelper {

    var $helpers = array('Html');
    
    function hasPicture($report){
        return !empty($report['Report']['picture']);
    }
    
    function smallImage($report){
        if ( $this->hasPicture($report) ){
            $basePath = WWW_ROOT.'img'.DS;
            $absPath = Configure::read('Report.ImageSmallDir');
            $relPath = str_replace($basePath,"",$absPath);
            $parts = explode(".",$report['Report']['picture']);
            if($parts[0]){
                return $this->Html->image($relPath.DS.$parts[0].".jpg", 
                    array('class'=>'hr-small-img'));
            }
        }
        return "";
    }

    function mediumImage($report){
        if ( $this->hasPicture($report) ){
            $basePath = WWW_ROOT.'img'.DS;
            $absPath = Configure::read('Report.ImageMediumDir');
            $relPath = str_replace($basePath,"",$absPath);
            $parts = explode(".",$report['Report']['picture']);
            if($parts[0]){
                return $this->Html->image($relPath.DS.$parts[0].".jpg", 
                    array('class'=>'hr-medium-img'));
            }
        }
        return "";
    }
    
    function status($status){
        $str = __('report.label.status.unknown',true);
        switch($status){
            case Report::STATUS_APPROVED:
                $str = __('report.label.status.approved',true);
                break;
            case Report::STATUS_PENDING:
                $str = __('report.label.status.pending',true);
                break;
            case Report::STATUS_REJECTED:
                $str = __('report.label.status.rejected',true);
                break;
        }
        return $str;
    }
    
    function shortBody($fullBody){
        return substr($fullBody,0,200)."...";
    }
    
    function showTags($tagCategories,$tagList){
        foreach($tagCategories as $category){
            echo "<b>".__d("tags",$category['TagCategory']['name'],true).":</b> ";
            $tagLinks = array();
            foreach($tagList as $tag){
                if($tag['tag_category_id']==$category['TagCategory']['id']){
                    $tagLinks[] = $this->linkToTag($tag);
                }
            }
            echo implode(" , ",$tagLinks);
            echo "<br />";
        }
    }

    function linkToTag($tag){
        $name = __d("tags",$tag['name'],true);
        $link = $this->Html->link($name, array(
                'controller'=>'tags','action'=>'reports_with',$tag['id']
        ));
        return $link;
    }
    
    function moderatorStatusClass($isModerator, $status){
        $statusCss = "";
        if($isModerator){
            $statusCss = "hr-report-status-".$status;
        }
        return $statusCss;
    }
    
}

?>