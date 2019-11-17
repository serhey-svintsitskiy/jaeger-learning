<?php


namespace AppTest;

use App\Calc;
use Aura\Di\Container;
use PHPUnit\Framework\TestCase;

class CalcTest extends TestCase
{
    protected function createObject()
    {
        /**
         * @var Container $container
         */
        global $container;
        return $container->get(Calc::class);
    }

    public function testCreate()
    {
        $object = $this->createObject();
        $result = call_user_func($object);
        $this->assertTrue(true);
    }

}