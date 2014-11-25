<?php
    class seTemplater
    {
        private $templateFolder, $currentType;
        public function __construct()
        {
            $this->templateFolder = SE_PATH."templates/";

        }
        public function setType($type)
        {
            if($type =="")
                throw new Exception("You need to specify a type");

            $this->currentType = $type;
        }
        private function scanFolder()
        {
            $files = scandir($this->templateFolder."/".$this->currentType);

            $path = $this->templateFolder.$this->currentType.'/';

            foreach($files as $file)
            {

                if(is_dir($path.'/'.$file) && $file!='.' && $file!='..')
                    $dirs[]=$file;
            }
            //var_dump($dirs);
            return $dirs;
        }
        private function getTemplateData($file)
        {
            $headers['name'] = "Template name";

            $fp = fopen( $file, 'r' );

            // Pull only the first 8kiB of the file in.
            $file_data = fread( $fp, 8192 );

            // PHP will close file handle, but we are good citizens.
            fclose( $fp );

            // Make sure we catch CR-only line endings.
            $file_data = str_replace( "\r", "\n", $file_data );
            foreach ( $headers as $field => $regex ) {
                if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, $match ) && $match[1] )
                    $all_headers[ $field ] = trim($match[1]);
                else
                    $all_headers[ $field ] = '';
            }

            return $all_headers;

        }
        private function extractTemplates($dirs)
        {

            $path = $this->templateFolder.$this->currentType;

            foreach($dirs as $dir)
            {

                //if it's a valid template
                if(is_file($path."/".$dir."/style.css"))
                {
                    $valid_templates[$dir]=$this->getTemplateData($path."/".$dir."/style.css");

                }
            }

            return $valid_templates;
        }
        public function getTemplates()
        {
            $dirs  = $this->scanFolder();

            //var_dump($dirs);



            $valid_templates = $this->extractTemplates($dirs);

            return $valid_templates;

            //var_dump($valid_templates);

            //Scan the folder for folder


            // for each folder
        }

    }

