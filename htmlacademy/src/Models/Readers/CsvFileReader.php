<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 01.11.2019
 * Time: 22:37
 */

namespace HtmlAcademy\Models\Readers;


use HtmlAcademy\Models\Ex\ReaderException;

/**
 * Class CsvReader
 * @package HtmlAcademy\Models\Readers
 */
class CsvFileReader extends AbstractFileReader implements ReaderInterface
{
    /**
     * @var string
     */
    protected $extensionCsv = 'csv';

    public function __construct($filePath)
    {
        parent::__construct($filePath);

        if ($this->extension !== $this->extensionCsv) {
            throw new ReaderException('Передан неверный формат файла');
        }

    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        $this->fileObject->rewind();

        $result = array();

        foreach ($this->fileObject->fgetcsv() as $value) {
            $result[] = $this->removeBom($value);
        }

        return $result;
    }

    /**
     * @return iterable
     */
    public function getLine(): iterable
    {
        // чтобы пропустить заголовок, иначе метод работает только 1 раз
        $this->fileObject->rewind();
        $this->fileObject->fgetcsv();

        while (!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv();
        }
    }
}
