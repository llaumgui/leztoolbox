<?php
/*!
\class eZBinaryFileParser ezbinaryfileparser.php
\ingroup eZKernel
\brief The class eZBinaryFileParser handles parsing of Word, Excel, Powerpoint, and PDF files and returns the metadata
*/
class eZBinaryFileParser
{
     function &parseFile( $sFileName )
     {
 
          //The number below is the maximum number of characters that we will
          //allow ezpublish to attempt to index per document
          $iCharacterLimit = 250000;
 
          // save the buffer contents
          $sBuffer =& ob_get_contents();
 
          ob_end_clean();
          ob_start();
          $sExtension = strtolower(substr($sFileName,-3,3));
 
          if(file_exists($sFileName))
          {
 
               $this->customLog("filename: " . $sFileName . "\n");
 
               switch($sExtension):
                    case "pdf":
                         $sCommand = "pdftotext -nopgbrk  -enc UTF-8 " . $sFileName . " -";
                    break;
                    case "doc":
                         $sCommand = "catdoc " . $sFileName . "";
                    break;
                    case "xls":
                         $sCommand = "xls2csv -c -q0 " . $sFileName . "";
                    break;
                    case "ppt":
                         $sCommand = "catppt " . $sFileName . "";
                    break;
                    default:
                         $this->customLog("Invalid File Type\n\n");
                         return false;
               endswitch;
 
               $aSpec = array(
                    0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
                    1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
                    2 => array("pipe", "w")   // stderr is a pipe that the child will write to.
               );
 
               $pHandle = proc_open($sCommand, $aSpec, $aPipes);
 
               while (!feof($aPipes[1]) )
               {
                    $sData .= fread($aPipes[1], 8192);
               }
               while (!feof($aPipes[2]) )
               {
                    $sError .= fread($aPipes[2], 8192);
               }
 
               if($sError)
               {
                    $this->customLog( $sError );
               }
 
               $bReturn = fclose($aPipes[1]);
               $bReturn = fclose($aPipes[2]);
 
               $iExitCode = proc_close($pHandle);
 
               $sData = preg_replace("([^A-Za-z\d\n])", " ", $sData);
 
               if($sExtension != "pdf")
               {
                    $sData = utf8_encode($sData);
               } 
 
               //Trim Data down to acceptable size.
               $sData = substr($sData, 0, $iCharacterLimit);
 
          } //if file exists
          else
          {
               $this->customLog("$sFileName was missing...\n");
               $sData = "";
          }
 
          ob_end_clean();
 
          // fill the buffer with the old values
          ob_start();
          print($sBuffer);
          return $sData;
 
     } //end method parseFile()
 
     function customLog($sData)
     {
          $oBinaryINI =& eZINI::instance( 'binaryfile.ini' );
          $sLogFile = $oBinaryINI->variable( 'BinaryFileHandlerSettings', 'LogFile' );
 
          $sData = date("m/d/Y [H:i] ") . " " . $sData;
 
          // Let's make sure the file exists and is writable first.
          if (is_writable($sLogFile))
          {
 
               // In our example we're opening $filename in append mode.
               // The file pointer is at the bottom of the file hence
               // that's where $somecontent will go when we fwrite() it.
               if (!$pHandle = fopen($sLogFile, 'a'))
               {
                    fwrite(STDERR,"Cannot open file ($sLogFile)");
                    return false;
               }
 
               // Write data to our opened file.
               if (fwrite($pHandle, $sData) === FALSE)
               {
                    fwrite(STDERR,"Cannot write to file ($sLogFile)");
                    return false;
               }
 
               fclose($pHandle);
               return true;
 
          }
          else
          {
               fwrite(STDERR,"The file $sLogFile is not writable");
               return false;
          } //end is_writable
     } //end method customLog()
} //end class eZBinaryFileParser
?>