<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once dirname(__FILE__, 2). '/src/File.php';

final class FileTest extends TestCase
{
    public function testGenerateFileFromFileString(): void
    {            
        //file with extension
        $this->assertInstanceOf(
            File::class,
            $file = File::fromFileString('file.exe')
        );

        $this->assertEquals('file.exe', $file->getName());

        //file without extension
        $file->setFileString('file');
        $this->assertEquals('file', $file->getName());

    }
}
