<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Db;

use byrokrat\giroapp\Db\ImportHistoryInterface;
use byrokrat\giroapp\Exception\FileAlreadyImportedException;
use byrokrat\giroapp\Filesystem\HashedFile;
use byrokrat\giroapp\Model\FileThatWasImported;
use Prophecy\Argument;

trait ImportHistorySpecTrait
{
    abstract function createImportHistory(): ImportHistoryInterface;

    function let()
    {
        $this->beConstructedThrough([$this, 'createImportHistory']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ImportHistoryInterface::CLASS);
    }

    function it_returns_null_if_file_was_not_imported()
    {
        $file = new HashedFile('name', 'content', 'hash');
        $this->fileWasImported($file)->shouldReturn(null);
    }

    function it_throws_if_the_same_hash_is_added_twice()
    {
        $this->addToImportHistory(new HashedFile('bar', 'bar', 'HASH'));
        $this->shouldThrow(FileAlreadyImportedException::CLASS)
            ->duringAddToImportHistory(new HashedFile('foo', 'foo', 'HASH'));
    }

    function it_does_not_throw_on_same_file_name_added_twice()
    {
        $this->addToImportHistory(new HashedFile('bar', 'bar', 'A'));
        $this->addToImportHistory(new HashedFile('bar', 'bar', 'not-A'));
    }

    function it_returns_file_previously_imported()
    {
        $file = new HashedFile('name', 'content', 'hash');
        $this->addToImportHistory($file);
        $this->fileWasImported($file)->shouldReturnFileNamed('name');
    }

    function it_finds_the_correct_imported_file_based_on_hash()
    {
        $this->addToImportHistory(new HashedFile('A', '', 'hashA'));
        $this->addToImportHistory(new HashedFile('B', '', 'hashB'));
        $this->fileWasImported(new HashedFile('', '', 'hashA'))->shouldReturnFileNamed('A');
    }

    public function getMatchers(): array
    {
        return [
            'returnFileNamed' => function (FileThatWasImported $file, string $expectedName) {
                return $file->getFilename() == $expectedName;
            }
        ];
    }
}
