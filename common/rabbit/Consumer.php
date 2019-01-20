<?php

/* This is a rabbitMQ Consumer Class for receving queued data from the RabbitMQ
 * Use this class to initiate a Queue to the Rabit Application
 * Written by: UCC:Charles Mhoja
 */

namespace common\rabbit;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class Consumer extends Producer {

    public function __construct($config = []) {
        parent::__construct($config);
    }

    /*
     * reading a queue from the RabbitMQ
     * $queue_name: Name of the queue to read can be black if want to read all the queus
     */

    public static function readQueue($queue_name = '') {
        $channel = $this->connection->channel();
        //$channel->queue_declare($queue_name, false, true, false, false);
        //  echo " [*] Waiting for messages. To exit press CTRL+C\n";
//        $callback = function ($msg) {
//            echo ' [x] Received ', $msg->body, "\n";
//        };
        $channel->basic_consume($queue_name, '', false, true, false, false, $callback = '');
        while (count($channel->callbacks)) {
            $channel->wait();
        }
        $channel->close(); //closing the channel
    }

}
