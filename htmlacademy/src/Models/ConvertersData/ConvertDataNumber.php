<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10.11.2019
 * Time: 15:41
 */

namespace HtmlAcademy\Models\ConvertersData;

/**
 * Class ConvertDataNumber
 * @package HtmlAcademy\Models\ConvertersData\Sql
 */
class ConvertDataNumber implements ConvertDataInterface
{
    /**
     * @param string $data
     * @return int
     */
    public function convert(string $data): int
    {
        return intval($data);
    }
}
