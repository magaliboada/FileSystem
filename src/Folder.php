<?php declare(strict_types=1);
final class Folder
{
    private $folderName;
    private $directoryList = [];
    private $created;
    private $path = '';

    private function __construct(string $folderName)
    {
        $this->folderName = $folderName;    
        $this->created = date("Y-m-d H:i:s");     
    }

    //Create a folder from a string
    public static function fromFolderString(string $folderName): self
    {
        return new self($folderName);
    }

    //Add new folder to a directory
    public function addNewFolder(Folder $folder)
    {        
        $folder->path = $this->path . '/' . $this->folderName;
        $this->directoryList[] = $folder;
    }

    //Add new file to a directory
    public function addNewFile(File $file)
    {
        $file->setPath($this->path . '/' . $this->folderName); 
        $this->directoryList[] = $file;
    }

    //List all items contained in this folder
    public function getDirectoryList() : array
    {
        return $this->directoryList;
    }

    //Creates the breabcrumb imploding the path to folder and the folder name
    public function getBreadcrumb() : string
    {
        return $this->path . '/' . $this->folderName;
    }

    //Get content directory with the following format: Name, Created Date and Boolean isDirectory
    public function getFormattedDirectory()  : array
    {
        $fullDirectory = $this->getDirectoryList();

        $table = [];

        foreach ($fullDirectory as $value) {

            $item['name'] = $value->getName();
            $item['created'] = $value->getCreated();
            $item['isDirectory'] = false;

            if ($value instanceof Folder) {
                $item['isDirectory'] = true;
            }

            $table[] = $item;
        }

        return $table;
    }

    public function getCreated() : string 
    {
        return $this->created;
    }


    public function getName() : string
    {
        return $this->folderName;
    }
    
}