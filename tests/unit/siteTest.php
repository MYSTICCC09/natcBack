<?php
//require Yii::app()->request->baseUrl.'/protected/controllers/*';

class siteTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testMe()
    {
        $site = new SiteController("site");
        $num = $site->test();
        $this->assertEquals(1, $num);
    }

}