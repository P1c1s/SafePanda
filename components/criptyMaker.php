<?php

   $chars = array('0','1','2','3','4','5','6','7','8','9',
   'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
   'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
   '*','#',
   '?','!','.',':',',',';','@','~',
   '<','^','>','(',')','[',']','{','}',
   '+','-','_','=','/','|','%',
   '$');

   $values = array('0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9,
   'a' => 10, 'b' => 11, 'c' => 12, 'd' => 13, 'e' => 14, 'f' => 15, 'g' => 16, 'h' => 17, 'i' => 18, 'j' => 19, 'k' => 20, 'l' => 21,
   'm' => 22, 'n' => 23, 'o' => 24, 'p' => 25, 'q' => 26, 'r' => 27, 's' => 28, 't' => 29, 'u' => 30, 'v' => 31, 'w' => 32, 'x' => 33,
   'y' => 34, 'z' => 35,
   'A' => 36, 'B' => 37, 'C' => 38, 'D' => 39, 'E' => 40, 'F' => 41, 'G' => 42, 'H' => 43, 'I' => 44, 'J' => 45, 'K' => 46, 'L' => 47,
   'M' => 48, 'N' => 49, 'O' => 50, 'P' => 51, 'Q' => 52, 'R' => 53, 'S' => 54, 'T' => 55, 'U' => 56, 'V' => 57, 'W' => 58, 'X' => 59,
   'Y' => 60, 'Z' => 61,
   '*' => 62, '#' => 63,
   '?' => 64, '!' => 65, '.' => 66, ':' => 67, ',' => 68, ';' => 69, '@' => 70, '~' => 71,
   '<' => 72, '^' => 73, '>' => 74, '(' => 75, ')' => 76, '[' => 77, ']' => 78, '{' => 79, '}' => 80,
   '+' => 81, '-' => 82, '_' => 83, '=' => 84, '/' => 85, '|' => 86, '%' => 87,
   '$' => 88);

   $dim=sizeof($chars);

   $fp = fopen("components/cripty.php", "w");

   if($fp){

      fwrite($fp, '<?php'."\n"."\n");
      fwrite($fp, '   $chars = array(');
      $str = "\n".'   $values = array(';

      for($i=0; $i<$dim; $i++){

         do{

            $r = rand(0, $dim-1);

         }while($chars[$r] == "empty");

         if($i!=$dim-1){
            fwrite($fp, "'".$chars[$r]."',");
            $str .= "'".$chars[$r]."'".' => '.$i.', ';
            $chars[$r] = "empty";
         }else
            fwrite($fp, "'".$chars[$r]."');");

      }

      $str .= "'".$chars[$r]."'".' => '.($i-1).');';
      fwrite($fp, $str);


      fwrite($fp, "\n"."\n".'   $dim=sizeof($chars);'."\n"."\n");

      fwrite($fp, '   function keyGenerator(){'."\n"."\n");
      fwrite($fp, '      global $chars, $dim;'."\n"."\n");
      fwrite($fp, '      for($i=0;$i<30;$i++){'."\n");
      fwrite($fp, '         $key[$i]=$chars[rand(0, $dim-1)];'."\n");
      fwrite($fp, '         $str.=$key[$i];'."\n");
      fwrite($fp, '      }'."\n"."\n");
      fwrite($fp, '      return $str;'."\n"."\n");
      fwrite($fp, '   }'."\n"."\n");

      fwrite($fp, '   function cry($password, $key){'."\n"."\n");
      fwrite($fp, '      $password = str_split($password, 1);'."\n"."\n");
      fwrite($fp, '      global $values, $chars, $dim;'."\n"."\n");
      fwrite($fp, '      $lun = sizeof($password);'."\n"."\n");
      fwrite($fp, '      $j=0;'."\n"."\n");
      fwrite($fp, '      for($i=0; $i<$lun; $i++){'."\n");
      fwrite($fp, '         if($c==3){'."\n");
      fwrite($fp, '            $j++;'."\n");
      fwrite($fp, '            $c=1;'."\n");
      fwrite($fp, '         }'."\n");
      fwrite($fp, '         else'."\n");
      fwrite($fp, '            $c++;'."\n"."\n");
      fwrite($fp, '      $position = ($values[$key[$j]]+$values[$password[$i]]);'."\n"."\n");
      fwrite($fp, '      if($position>=$dim)'."\n");
      fwrite($fp, '         $position -= $dim;'."\n"."\n");
      fwrite($fp, '      $newPassword[$i] = $chars[$position];'."\n"."\n");
      fwrite($fp, '      $str .= $newPassword[$i];'."\n"."\n");
      fwrite($fp, '      }'."\n"."\n");
      fwrite($fp, '      return $str;'."\n"."\n");
      fwrite($fp, '   }'."\n"."\n");



      fwrite($fp, '   function decry($password, $key){'."\n"."\n");
      fwrite($fp, '      $password = str_split($password, 1);'."\n"."\n");
      fwrite($fp, '      global $values, $chars, $dim;'."\n"."\n");
      fwrite($fp, '      $lun = sizeof($password);'."\n"."\n");
      fwrite($fp, '      $j=0;'."\n"."\n");
      fwrite($fp, '      for($i=0; $i<$lun; $i++){'."\n");
      fwrite($fp, '         if($c==3){'."\n");
      fwrite($fp, '            $j++;'."\n");
      fwrite($fp, '            $c=1;'."\n");
      fwrite($fp, '         }'."\n");
      fwrite($fp, '         else'."\n");
      fwrite($fp, '            $c++;'."\n"."\n");
      fwrite($fp, '      $position = $values[$password[$i]];'."\n"."\n");
      fwrite($fp, '      $position-=$values[$key[$j]];'."\n"."\n");
      fwrite($fp, '      if($position<0)'."\n");
      fwrite($fp, '         $position+=$dim;'."\n"."\n");
      fwrite($fp, '      $password[$i] = $chars[$position];'."\n"."\n");
      fwrite($fp, '      $str .= $password[$i];'."\n"."\n");
      fwrite($fp, '      }'."\n"."\n");
      fwrite($fp, '   return $str;'."\n"."\n");
      fwrite($fp, '   }'."\n");




      fwrite($fp, "\n"."\n".'?>');
      fclose($fp);

   }else
      echo 'Error to open file';




?>

