<?php

public class getFileFromFTP {
 
//Setting Ftp details - Change as per your data
        private ftpHost = 'ftp_host';
        private ftpUser = 'ftp_username';
        private ftpPassword = 'ftp_password';
//Setting Ftp details END
        
        public function ftpCrawl(){
                $ftpConn = ftp_connect($this->ftpHost);
                $login = ftp_login($ftpConn, $this->ftpUser, $this->ftpPassword);
                $mode = ftp_pasv($ftpConn, TRUE);
                
                $filename = "File Name Here";
                $filePath = "File Path Here";
                if ((!$ftpConn) || (!$login) || (!$mode)) {
			echo 'FTP connection has failed! Attempted to connect to ' . $this->ftpHost . ' for user ' . $this->ftpUser . '.';
		} else {
			$this->parseCSVFile($ftpConn, $filename, $filePath);
		}
        }
        
        public function parseCSVFile($ftpConn, $filename, $filePath)
	{
//                 Navigating to file Path
                ftp_chdir($ftpConn, $filePath);
//                 Checking if any file there
                $result = ftp_size($ftpConn, $filename);
                if ($res != -1) {
//                         Temporary File location
                        $tmpPath = fopen('php://temp', 'r+');
                        
                        if (ftp_fget($ftpConn, $tmpPath, $filename, FTP_ASCII)) {
                                @rewind($tmpPath);
                                
                                $index = 0;
                                while(fgets($tmpPath)){
                                        $csvData[$index] = fgetcsv(fgets($tmpPath)); //fetching Each row in csv and storing into Array
                                        $index++;
                                }
                        }
                        
                        fclose($tmpPath);
                }else{
                       echo $filename . ' blank file or file not found...';
                }
                
                return $csvData;
        }
        
        
        
}
