<?php

/** 
 * Esta classe é a união de códigos que achei pela internet
 * e estou utilizando para complementar a minha.
 */

class bmpGd{

    private function ConvertBMP2GD($src, $dest = false) {
        if(!($src_f = fopen($src, "rb"))) {
           return false;
        }
        if(!($dest_f = fopen($dest, "wb"))) {
           return false;
        }
        
        $header = unpack("vtype/Vsize/v2reserved/Voffset", fread($src_f,14));
        $info = unpack("Vsize/Vwidth/Vheight/vplanes/vbits/Vcompression/Vimagesize/Vxres/Vyres/Vncolor/Vimportant",
        fread($src_f, 40));
        
        extract($info);
        extract($header);
        
        if($type != 0x4D42) { // signature "BM"
           return false;
        }
        
        $palette_size = $offset - 54;
        $ncolor = $palette_size / 4;
        $gd_header = "";
        
        // true-color vs. palette
        $gd_header .= ($palette_size == 0) ? "\xFF\xFE" : "\xFF\xFF";
        $gd_header .= pack("n2", $width, $height);
        $gd_header .= ($palette_size == 0) ? "\x01" : "\x00";
        
        if($palette_size) {
           $gd_header .= pack("n", $ncolor);
        }
        
        // no transparency
        $gd_header .= "\xFF\xFF\xFF\xFF";
        
        fwrite($dest_f, $gd_header);
        
        if($palette_size) {
           $palette = fread($src_f, $palette_size);
           $gd_palette = "";
           $j = 0;
           
           while($j < $palette_size) {
                 $b = $palette{$j++};
                 $g = $palette{$j++};
                 $r = $palette{$j++};
                 $a = $palette{$j++};
                 $gd_palette .= "$r$g$b$a";
           }
           
           $gd_palette .= str_repeat("\x00\x00\x00\x00", 256 - $ncolor);
           fwrite($dest_f, $gd_palette);
        }
        
        $scan_line_size = (($bits * $width) + 7) >> 3;
        $scan_line_align = ($scan_line_size & 0x03) ? 4 - ($scan_line_size &0x03) : 0;
        
        for($i = 0, $l = $height - 1; $i < $height; $i++, $l--) {
            // BMP stores scan lines starting from bottom
            fseek($src_f, $offset + (($scan_line_size + $scan_line_align) *$l));
            $scan_line = fread($src_f, $scan_line_size);
            
            if($bits == 24) {
               $gd_scan_line = "";
               $j = 0;
               
               while($j < $scan_line_size) {
                     $b = $scan_line{$j++};
                     $g = $scan_line{$j++};
                     $r = $scan_line{$j++};
                     $gd_scan_line .= "\x00$r$g$b";
               }
               
            } else if ($bits == 8) {
                       $gd_scan_line = $scan_line;
            } else if ($bits == 4) {
                       $gd_scan_line = "";
                       $j = 0;
                      
                       while($j < $scan_line_size) {
                             $byte = ord($scan_line{$j++});
                             $p1 = chr($byte >> 4);
                             $p2 = chr($byte & 0x0F);
                             $gd_scan_line .= "$p1$p2";
                       } 
                       $gd_scan_line = substr($gd_scan_line, 0, $width);
            } else if ($bits == 1) {
                       $gd_scan_line = "";
                       $j = 0;
                       
                       while($j < $scan_line_size) {
                             $byte = ord($scan_line{$j++});
                             $p1 = chr((int) (($byte & 0x80) != 0));
                             $p2 = chr((int) (($byte & 0x40) != 0));
                             $p3 = chr((int) (($byte & 0x20) != 0));
                             $p4 = chr((int) (($byte & 0x10) != 0));
                             $p5 = chr((int) (($byte & 0x08) != 0));
                             $p6 = chr((int) (($byte & 0x04) != 0));
                             $p7 = chr((int) (($byte & 0x02) != 0));
                             $p8 = chr((int) (($byte & 0x01) != 0));
                             $gd_scan_line .= "$p1$p2$p3$p4$p5$p6$p7$p8";
                       }
                       
                       $gd_scan_line = substr($gd_scan_line, 0, $width);
            }
            
            fwrite($dest_f, $gd_scan_line);
        }
        fclose($src_f);
        fclose($dest_f);
        return true;
    }
    
    // imagebmp helpers
    private function int_to_dword($n) {
        return chr($n & 255).chr(($n >> 8) & 255).chr(($n >> 16) & 255).chr(($n >> 24) & 255);
    }
    
    private function int_to_word($n) {
        return chr($n & 255).chr(($n >> 8) & 255);
    }
    
    /**
     * creates image from a Windows BMP picture
     * @see imagecreatefromgif, imagecreatefromjpeg ...
     */
    protected function imagecreatefrombmp($filename) {
        $tmp_name = tempnam("/tmp", "GD");
        
        if($this->ConvertBMP2GD($filename, $tmp_name)) {
           $img = imagecreatefromgd($tmp_name);
           unlink($tmp_name);
           return $img;
        } 
        return false;
    } 
    
    /**
     * creates a Windows BMP picture
     * @see imagegif, imagejpeg ...
     */
    protected function imagebmp(&$img, $filename=""){
        $widthOrig = imagesx($img);
        // width = 16*x
        $widthFloor = ((floor($widthOrig/16))*16);
        $widthCeil = ((ceil($widthOrig/16))*16);
        $height = imagesy($img);
        
        $size = ($widthCeil*$height*3)+54;
        
        // Bitmap File Header
        $result = 'BM';     // header (2b)
        $result .= $this->int_to_dword($size); // size of file (4b)
        $result .= $this->int_to_dword(0); // reserved (4b)
        $result .= $this->int_to_dword(54);  // byte location in the file which is first byte of IMAGE (4b)
        // Bitmap Info Header
        $result .= $this->int_to_dword(40);  // Size of BITMAPINFOHEADER (4b)
        $result .= $this->int_to_dword($widthCeil);  // width of bitmap (4b)
        $result .= $this->int_to_dword($height); // height of bitmap (4b)
        $result .= $this->int_to_word(1);  // biPlanes = 1 (2b)
        $result .= $this->int_to_word(24); // biBitCount = {1 (mono) or 4 (16 clr ) or 8 (256 clr) or 24 (16 Mil)} (2b)
        $result .= $this->int_to_dword(0); // RLE COMPRESSION (4b)
        $result .= $this->int_to_dword(0); // width x height (4b)
        $result .= $this->int_to_dword(0); // biXPelsPerMeter (4b)
        $result .= $this->int_to_dword(0); // biYPelsPerMeter (4b)
        $result .= $this->int_to_dword(0); // Number of palettes used (4b)
        $result .= $this->int_to_dword(0); // Number of important colour (4b)
        
        // is faster than chr()
        $arrChr = array();
        for ($i=0; $i<256; $i++) {
             $arrChr[$i] = chr($i);
        }
        
        // creates image data
        $bgfillcolor = array("red"=>0, "green"=>0, "blue"=>0);
        
        // bottom to top - left to right - attention blue green red !!!
        $y=$height-1;
        for ($y2=0; $y2<$height; $y2++) {
           for ($x=0; $x<$widthFloor;  ) {
                $rgb = imagecolorsforindex($img, imagecolorat($img, $x++, $y));
                $result .= $arrChr[$rgb["blue"]].$arrChr[$rgb["green"]].$arrChr[$rgb["red"]];
                $rgb = imagecolorsforindex($img, imagecolorat($img, $x++, $y));
                $result .= $arrChr[$rgb["blue"]].$arrChr[$rgb["green"]].$arrChr[$rgb["red"]];
                $rgb = imagecolorsforindex($img, imagecolorat($img, $x++, $y));
                $result .= $arrChr[$rgb["blue"]].$arrChr[$rgb["green"]].$arrChr[$rgb["red"]];
                $rgb = imagecolorsforindex($img, imagecolorat($img, $x++, $y));
                $result .= $arrChr[$rgb["blue"]].$arrChr[$rgb["green"]].$arrChr[$rgb["red"]];
                $rgb = imagecolorsforindex($img, imagecolorat($img, $x++, $y));
                $result .= $arrChr[$rgb["blue"]].$arrChr[$rgb["green"]].$arrChr[$rgb["red"]];
                $rgb = imagecolorsforindex($img, imagecolorat($img, $x++, $y));
                $result .= $arrChr[$rgb["blue"]].$arrChr[$rgb["green"]].$arrChr[$rgb["red"]];
                $rgb = imagecolorsforindex($img, imagecolorat($img, $x++, $y));
                $result .= $arrChr[$rgb["blue"]].$arrChr[$rgb["green"]].$arrChr[$rgb["red"]];
                $rgb = imagecolorsforindex($img, imagecolorat($img, $x++, $y));
                $result .= $arrChr[$rgb["blue"]].$arrChr[$rgb["green"]].$arrChr[$rgb["red"]];
           }
           for ($x=$widthFloor; $x<$widthCeil; $x++) {
                $rgb = ($x<$widthOrig) ? imagecolorsforindex($img, imagecolorat($img, $x, $y)) : $bgfillcolor;
                $result .= $arrChr[$rgb["blue"]].$arrChr[$rgb["green"]].$arrChr[$rgb["red"]];
           }
           $y--;
        }
        
        // see imagegif
        if($filename=="") {
           return $result;
        } else {
           $file = fopen($filename, "wb");
           fwrite($file, $result);
           fclose($file);
        }
    }
}
?>