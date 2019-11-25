<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 02.11.2019
 * Time: 0:14
 */

namespace HtmlAcademy\Models\Writes;

/**
 * Class SqlWriter
 * @package HtmlAcademy\Models\Writes
 */
class SqlWriter extends AbstractWriter
{
    /**
     * @var string
     */
    protected $extension = '.sql';

    /**
     * @var string
     */
    private $filePath;

    /**
     * @var \SplFileObject
     */
    private $fileToWrite;

    /**
     * SqlWriter constructor.
     * @param string $dirName
     * @param string $fileName
     * @param string $tableName
     * @param array $typeColumns
     */
    public function __construct($dirName, $fileName, $tableName, array $typeColumns = array())
    {
        $this->link = mysqli_connect('docker-machine', 'pinba', '', 'pinba', 3307);
        parent::__construct($dirName, $fileName, $tableName, $typeColumns);

        $this->setFilePath();
        $this->fileToWrite = new \SplFileObject($this->filePath, "w");
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * Метод создает файл
     */
    public function setFilePath(): void
    {
        $this->filePath = $this->dirName . $this->fileName . $this->extension;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }


    /**
     * @param array $columns
     * @param array $row
     */
    public function write(array $columns, array $row): void
    {
        foreach ($row as &$item) {
            // т.к. мы знаем, что все кроме строк уже пришло нормализованное - строки мы экраниеруем
            if (is_string($item)) {
                // в идеале экранировать нужно через родную функцию mysqliConvertDataString
                $item = mysqli_real_escape_string($this->link, $item);
            }
        }
        $this->fileToWrite->fwrite('INSERT INTO' . ' ' . $this->tableName . '(`' . implode('`,`', $columns) . '`) VALUES (' . implode(',', $row) . ');' . PHP_EOL);
    }

}
