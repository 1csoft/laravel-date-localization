<?php
/**
 * Created by OOO 1C-SOFT.
 * User: Dremin_S
 * Date: 06.03.2020
 */

namespace Tests\Unit;

use Soft1c\Date\Date;
use Tests\TestCase;

class LocaleDateTest extends TestCase
{
    /**
     * @method testPluralMonth
     * @param string $day
     * @param string $month
     * @param int $year
     *
     * @dataProvider providerFormat
     */
    public function testPluralMonth(string $day, string $month)
    {
        $date = new Date('01.05.2020');
        $date->locale('ru');
        $format = $day.' '.$month;
        $formatted = $date->format($format);
        dump($formatted);
        $this->assertIsString($formatted);
    }

    /**
     * @method testMonth
     * @param $format
     *
     * @dataProvider providerMonth
     */
    public function testMonth($format)
    {
        $date = new Date('01.05.2020');
        $date->locale('ru');
        $formatted = $date->format($format);
        dump($formatted);
        $this->assertIsString($formatted);
    }

    /**
     * @method providerFormat
     */
    public function providerFormat()
    {
        return [
            ['j', 'F'],
            ['j', 'M'],
        ];
    }

    /**
     * @method providerMonth
     * @return \string[][]
     */
    public function providerMonth()
    {
        return [
            ['F'],
            ['M'],
        ];
    }
}
