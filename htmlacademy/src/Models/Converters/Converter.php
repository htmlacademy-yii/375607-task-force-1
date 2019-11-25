<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 01.11.2019
 * Time: 20:15
 */

namespace HtmlAcademy\Models\Converters;

use HtmlAcademy\Models\Ex\ConverterException;
use HtmlAcademy\Models\Readers\AbstractFileReader;
use HtmlAcademy\Models\Readers\ReaderInterface;
use HtmlAcademy\Models\Writes\AbstractWriter;

/**
 * Class Converter
 * @package HtmlAcademy\Models\Converters
 */
abstract class Converter
{
    /**
     * @var AbstractFileReader
     */
    protected $reader;

    /**
     * @var AbstractWriter
     */
    protected $writer;

    /**
     * Converter constructor.
     * @param ReaderInterface $reader
     * @param AbstractWriter $writer
     * @param array $data
     */
    public function __construct(ReaderInterface $reader, AbstractWriter $writer)
    {

        $this->reader = $reader;
        $this->writer = $writer;
    }

    /**
     * @return mixed
     */
    abstract public function import();

    /**
     * @param string $data
     * @return mixed
     */
    abstract public function convertData(string $data);
}
