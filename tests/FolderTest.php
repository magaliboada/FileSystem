<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once dirname(__FILE__, 2). '/src/Folder.php';
require_once dirname(__FILE__, 2). '/src/File.php';

final class FolderTest extends TestCase
{
    public function testCanBeCreatedFromValidFolderName(): void
    {            
        $this->assertInstanceOf(
            Folder::class,
            $folder = Folder::fromFolderString('Folder Name')
        );
    }

    public function testFolderCanBeAdded(): void
    {
        $folder = Folder::fromFolderString('Folder Name');
        $newSubFolder = Folder::fromFolderString('Folder Name2');
        $folder->addNewFolder($newSubFolder);

        $this->assertContains($newSubFolder, $folder->getDirectoryList());        
    }

    public function testFileCanBeAdded(): void
    {
        $folder = Folder::fromFolderString('Folder Name');
        $newSubFolder = File::fromFileString('File Name.txt');
        $folder->addNewFile($newSubFolder);

        $this->assertContains($newSubFolder, $folder->getDirectoryList());        
    }

    public function testFilePath(): void
    {
        $folder = Folder::fromFolderString('Folder Name');

        $newFolder2 = Folder::fromFolderString('Folder2Level2');
        $folder->addNewFolder($newFolder2);

        $newFolder3 = Folder::fromFolderString('Folder3Level3');
        $newFolder2->addNewFolder($newFolder3);

        $newFolder4 = Folder::fromFolderString('Folder4Level4');
        $newFolder3->addNewFolder($newFolder4);

        $newFile = File::fromFileString('File Name.txt');
        $folder->addNewFile($newFile);

        $this->assertContains($newFolder2, $folder->getDirectoryList());   
        $this->assertContains($newFolder3, $newFolder2->getDirectoryList());   
        $this->assertContains($newFolder4, $newFolder3->getDirectoryList());          
    }

    public function testBreadcrumb(): void
    {
        $folder = Folder::fromFolderString('Folder Name');
        $newFolder = Folder::fromFolderString('FolderLevel1');
        $folder->addNewFolder($newFolder);

        $newFolder2 = Folder::fromFolderString('Folder2Level2');
        $folder->addNewFolder($newFolder2);

        $newFolder3 = Folder::fromFolderString('Folder3Level3');
        $newFolder2->addNewFolder($newFolder3);

        $this->assertEquals('/Folder Name/Folder2Level2/Folder3Level3' , $newFolder3->getBreadcrumb());
    }

    public function testFormattingTable(): void
    {
        $folder = Folder::fromFolderString('Folder Name');

        $newFolder2 = Folder::fromFolderString('Folder2Level2');
        $folder->addNewFolder($newFolder2);

        $newFile = File::fromFileString('File Name.txt');
        $folder->addNewFile($newFile);

        $formattedTable = $folder->getFormattedDirectory();

        $formattedItem = ['name' => 'Folder2Level2', 'created' => date("Y-m-d H:i:s"), 'isDirectory' => true];
        $this->assertContains($formattedItem, $formattedTable); 

        $formattedItem = ['name' => 'File Name.txt', 'created' => date("Y-m-d H:i:s"), 'isDirectory' => false];
        $this->assertContains($formattedItem, $formattedTable); 

        // print(var_export($formattedTable, true));
    }
}
