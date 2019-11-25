<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10.11.2019
 * Time: 16:50
 */

namespace HtmlAcademy\Models\ConvertersData;

/**
 * Class ConvertDataStringSql
 * @package HtmlAcademy\Models\Sql\ConvertersData
 */
class ConvertDataString implements ConvertDataInterface
{
    /**
     * @param string $data
     * @return string
     */
    public function convert(string $data): string
    {
        return $data;
    }
}
