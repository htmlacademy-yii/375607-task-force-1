<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10.11.2019
 * Time: 15:55
 */

namespace HtmlAcademy\Models\Converters;
use HtmlAcademy\Models\ConvertersData\ConvertDataFloat;
use HtmlAcademy\Models\ConvertersData\ConvertDataInterface;
use HtmlAcademy\Models\ConvertersData\ConvertDataNumber;
use HtmlAcademy\Models\ConvertersData\ConvertDataString;
use HtmlAcademy\Models\Ex\ConverterException;
use HtmlAcademy\Models\RandomData\RandomDataDate;
use HtmlAcademy\Models\RandomData\RandomDataInterface;
use HtmlAcademy\Models\RandomData\RandomDataNumber;
use HtmlAcademy\Models\Readers\ReaderInterface;
use HtmlAcademy\Models\Writes\AbstractWriter;


/**
 * Class ConverterCsvToSql
 * @package HtmlAcademy\Models\Converters
 */
class ConverterParticular extends Converter
{
    /**
     * @array
     */
    private $dataForConvert;

    /**
     * @var array
     */
    private $randomData;

    /**
     * @var
     */
    private $fieldIncrement;

    /**
     * ConverterParticular constructor.
     * @param ReaderInterface $reader
     * @param AbstractWriter $writer
     * @param array $dataForConvert
     * @param array $randomData
     * @throws ConverterException
     */
    public function __construct(ReaderInterface $reader, AbstractWriter $writer, array $dataForConvert, array $randomData = array(), string $fieldIncrement = '')
    {
        if (empty($dataForConvert)) {
            throw new ConverterException('Массив данных для преобразования в Sql формат, должен быть заполнен');
        }

        parent::__construct($reader, $writer);
        $this->dataForConvert = $dataForConvert;
        $this->randomData = $randomData;
        $this->fieldIncrement = $fieldIncrement;
    }

    /**
     * @throws ConverterException
     */
    public function import(): void
    {
        $headers = $this->reader->getHeaders();

        if($this->fieldIncrement && !in_array($this->fieldIncrement, $headers)) {
            array_unshift($headers, $this->fieldIncrement);
        }

        if (count($headers) !== count($this->dataForConvert)) {
            throw new ConverterException('Переданы не все столбцы для конвертации данных');
        }

        $count = 0;
        foreach ($this->reader->getLine() as $line) {
            $formatData = array();

            if($this->fieldIncrement) {
                array_unshift($line, ++$count);
            }

            if (count($headers) !== count($line)) {
                continue;
            }

            foreach ($headers as $key => $data) {

                if (!empty($this->randomData) && array_key_exists($data, $this->randomData)) {
                    $keyRandomData = key($this->randomData[$data]);
                    $line[$key] = $this->getRandomData($keyRandomData)->get($this->randomData[$data][$keyRandomData]);
                }

                $formatData[$key] = $this->convertData($this->dataForConvert[$data])->convert($line[$key]);
            }


            $this->writer->write($headers, $formatData);
        }
    }

    /**
     * @param string $data
     * @return RandomDataInterface|null
     * @throws ConverterException
     */
    public function getRandomData(string $data): ? RandomDataInterface
    {

        switch ($data) {
            case 'date':
                return new RandomDataDate();
            case 'number':
                return new RandomDataNumber();
        }

        throw new ConverterException($data . ' такого генератора cлучайных данных не существует');
    }

    /**
     * @param string $data
     * @return ConvertDataInterface|null
     * @throws ConverterException
     */
    public function convertData(string $data): ? ConvertDataInterface
    {

        switch ($data) {
            case 'string':
                return new ConvertDataString();
            case 'number':
                return new ConvertDataNumber();
            case 'float':
                return new ConvertDataFloat();

        }

        throw new ConverterException($data . ' такого преобразователя данных не существует');
    }

}