<?php
/**
 * NextFlow (http://github.com/nextflow)
 *
 * @link http://github.com/nextflow/nextflow-php for the canonical source repository
 * @copyright Copyright (c) 2014 NextFlow (http://github.com/nextflow)
 * @license https://raw.github.com/nextflow/nextflow-php/master/LICENSE MIT
 */

namespace NextFlowTest\Core\Scene;

use NextFlow\Php\Variable\AnyVariable;
use NextFlow\Core\Condition\SwitchCondition;

class SwitchConditionTest extends \PHPUnit_Framework_TestCase
{
    public function testFirstSocket()
    {
        $neverAction = $this->getMock('NextFlow\Core\Action\AbstractAction', array('execute'));
        $neverAction->expects($this->never())->method('execute');

        $action = $this->getMock('NextFlow\Core\Action\AbstractAction', array('execute'));
        $action->expects($this->once())->method('execute');

        $condition = new SwitchCondition();
        $condition->bind(SwitchCondition::SOCKET_VALUE, new AnyVariable(1));
        $condition->bind(1, $action);
        $condition->bind(2, $neverAction);
        $condition->bind(3, $neverAction);
        $this->assertCount(4, $condition->getSockets());

        $condition->execute();
    }

    public function testMiddleSocket()
    {
        $neverAction = $this->getMock('NextFlow\Core\Action\AbstractAction', array('execute'));
        $neverAction->expects($this->never())->method('execute');

        $action = $this->getMock('NextFlow\Core\Action\AbstractAction', array('execute'));
        $action->expects($this->once())->method('execute');

        $condition = new SwitchCondition();
        $condition->bind(SwitchCondition::SOCKET_VALUE, new AnyVariable(2));
        $condition->bind(1, $neverAction);
        $condition->bind(2, $action);
        $condition->bind(3, $neverAction);
        $this->assertCount(4, $condition->getSockets());

        $condition->execute();
    }

    public function testLastSocket()
    {
        $neverAction = $this->getMock('NextFlow\Core\Action\AbstractAction', array('execute'));
        $neverAction->expects($this->never())->method('execute');

        $action = $this->getMock('NextFlow\Core\Action\AbstractAction', array('execute'));
        $action->expects($this->once())->method('execute');

        $condition = new SwitchCondition();
        $condition->bind(SwitchCondition::SOCKET_VALUE, new AnyVariable(3));
        $condition->bind(1, $neverAction);
        $condition->bind(2, $neverAction);
        $condition->bind(3, $action);
        $this->assertCount(4, $condition->getSockets());

        $condition->execute();
    }

    public function testNoValidValue()
    {
        $neverAction = $this->getMock('NextFlow\Core\Action\AbstractAction', array('execute'));
        $neverAction->expects($this->never())->method('execute');

        $condition = new SwitchCondition();
        $condition->bind(SwitchCondition::SOCKET_VALUE, new AnyVariable(4));
        $condition->bind(1, $neverAction);
        $condition->bind(2, $neverAction);
        $condition->bind(3, $neverAction);
        $this->assertCount(4, $condition->getSockets());

        $condition->execute();
    }
}
