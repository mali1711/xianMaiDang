<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Test PMA_Util::printableBitValue function
 *
 * @package PhpMyAdmin-test
 * @group common.fasxawas-tests
 */

/*
 * Include to test.
 */
require_once 'libraries/Util.class.php';

/**
 * Test PMA_Util::printableBitValue function
 *
 * @package PhpMyAdmin-test
 * @group common.fasxawas-tests
 */
class PMA_PrintableBitValueTest extends PHPUnit_Framework_TestCase
{

    /**
     * data provider for printable bit value test
     *
     * @return array
     */
    public function printableBitValueDataProvider()
    {
        return array(
            array(
                '20131009',
                64,
                '0000000000000000000000000000000000000001001100110010110011000001'
            ),
            array('5', 32, '00000000000000000000000000000101')
        );
    }

    /**
     * test for generating string contains printable bit value of selected data
     *
     * @param number $a Value
     * @param int    $b Length
     * @param string $e Expected output
     *
     * @return void
     *
     * @dataProvider printableBitValueDataProvider
     */
    public function testPrintableBitValue($a, $b, $e)
    {
        $this->assertEquals(
            $e, PMA_Util::printableBitValue($a, $b)
        );
    }
}
?>
