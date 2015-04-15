<?php


namespace Framework\Maps;


use Officium\Framework\Controllers\SessionController;
use Officium\Framework\Maps\SessionMap;

class SessionMapTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function When_UriCalled_UriReturned()
    {
        $this->assertEquals('/experiment/session/add', SessionMap::toUri());
    }

    /**
     * @test
     */
    public function When_PathToControllerCalled_PathReturned()
    {
        $controller = get_class(new SessionController());
        $this->assertEquals($controller.':get', SessionMap::toController());
    }
}
