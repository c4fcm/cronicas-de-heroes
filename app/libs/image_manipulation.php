<?php 

class ImageManipulation {
    
    public function generateThumbAndMedium($fileName){
        $path = Configure::read('Report.ImageDir').DS.$fileName;
        $parts = explode(".",$fileName);
        $extension = strtolower($parts[1]);
        $im = null;
        switch($extension){
            case 'jpg':
            case 'jpeg':
                $im = @imagecreatefromjpeg($path);
                break;
            case 'gif':
                $im = @imagecreatefromgif($path);
                break;
            case 'png':
                $im = @imagecreatefrompng($path);
                break;
            default:
                echo("ERROR: unknown image type ".$extension);
                return;
        }
        
        $origSize = getimagesize($path);
        
        // create the thumbnail
        $thumbPath = Configure::read('Report.ImageSmallDir').DS.$parts[0].".jpg";
        $smallWidth = Configure::read('Report.ImageSmallWidth');
        $scale = $smallWidth/$origSize[0];
        if($scale>1) $scale=1;
        $dstWidth = $origSize[0]*$scale;
        $dstHeight = $origSize[1]*$scale;
        $thumb = imagecreatetruecolor($dstWidth,$dstHeight);
        imagecopyresized($thumb,$im,0,0,0,0,$dstWidth,$dstHeight,$origSize[0],$origSize[1]);
        imagejpeg($thumb,$thumbPath);
        imagedestroy($thumb);
        
        // create the medium
        $mediumPath = Configure::read('Report.ImageMediumDir').DS.$parts[0].".jpg";
        $mediumWidth = Configure::read('Report.ImageMediumWidth');
        $scale = $mediumWidth/$origSize[0];
        if($scale>1) $scale=1;
        $dstWidth = $origSize[0]*$scale;
        $dstHeight = $origSize[1]*$scale;
        $medium = imagecreatetruecolor($dstWidth,$dstHeight);
        imagecopyresized($medium,$im,0,0,0,0,$dstWidth,$dstHeight,$origSize[0],$origSize[1]);
        imagejpeg($medium,$mediumPath);
        imagedestroy($medium);
        
        imagedestroy($im);
    }
    
}

?>