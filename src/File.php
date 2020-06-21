<?php declare(strict_types=1);
final class File
{
    private $fileName;
    private $fileExtension;
    private $created;
    private $path;

    private function __construct(string $fileString)
    {
        $this->setFileString($fileString);       
        $this->created = date("Y-m-d H:i:s"); 
    }

    public static function fromFileString(string $fileString): self
    {
        return new self($fileString);
    }

    //Set File Values; File Name and File Extension
    public function setFileString(string $fileString) : void 
    {
        $this->setExtension($fileString);
        $this->fileName = str_replace('.' . $this->fileExtension, "", $fileString);
    }

    //Get File String; File Name and File Extension
    public function getName() : string 
    {
        if(!empty($this->fileExtension))
            return implode('.', [$this->fileName, $this->fileExtension]);
        else
            return $this->fileName;
    }

    //Set extension if existis, else leave blank
    private function setExtension(string $fileString): void 
    {
        $fileExtension = explode('.', $fileString); 

        if(count($fileExtension) <= 1)
            $this->fileExtension = '';
        else {
            $fileExtension = $fileExtension[count($fileExtension)-1];
            $this->fileExtension = $fileExtension;
        }    
    }

    //Set Path
    public function setPath(string $path) 
    {
        $this->path = $path;
    }

    //Get created
    public function getCreated() : string 
    {
        return $this->created;
    }

    
    
}