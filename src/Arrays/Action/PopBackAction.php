<?php
/**
 * NextFlow (http://github.com/nextflow)
 *
 * @link http://github.com/nextflow/nextflow-php for the canonical source repository
 * @copyright Copyright (c) 2014 NextFlow (http://github.com/nextflow)
 * @license https://raw.github.com/nextflow/nextflow-php/master/LICENSE MIT
 */

namespace NextFlow\Arrays\Action;

use NextFlow\Core\Action\AbstractAction;

/**
 * Pops an element from the back of an array.
 */
class PopBackAction extends AbstractAction
{
    /** The output action socket. */
    const SOCKET_OUTPUT = 'out';

    /** The array variable socket. */
    const SOCKET_ARRAY = 'array';

    /** The data variable socket. */
    const SOCKET_DATA = 'data';

    /**
     * Initializes a new instance of this class.
     */
    public function __construct()
    {
        parent::__construct();

        $this->createSocket(self::SOCKET_OUTPUT);
        $this->createSocket(self::SOCKET_ARRAY);
        $this->createSocket(self::SOCKET_DATA);
    }

    /**
     * Executes the node's logic.
     */
    public function execute()
    {
        $array = $this->getSocket(self::SOCKET_ARRAY)->getNode(0);
        if ($array === null) {
            throw new \InvalidArgumentException('No array variable provided.');
        }

        $arrayValue = $array->getValue();
        $poppedValue = array_pop($arrayValue);
        $array->setValue($arrayValue);

        $dataSocket = $this->getSocket(self::SOCKET_DATA);
        if ($dataSocket->hasNodes()) {
            $dataSocket->getNode(0)->setValue($poppedValue);
        }

        $this->activate(self::SOCKET_OUTPUT);
    }
}
