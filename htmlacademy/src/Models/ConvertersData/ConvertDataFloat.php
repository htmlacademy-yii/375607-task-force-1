<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10.11.2019
 * Time: 16:52
 */

namespace HtmlAcademy\Models\ConvertersData;

/**
 * Class ConvertDataFloat
 * @package HtmlAcademy\Models\ConvertersData
 */
class ConvertDataFloat implements ConvertDataInterface
{
    /**
     * @param string $data
     * @return float
     */
    public function convert(string $data): float
    {
        return (float)$data;
    }
}