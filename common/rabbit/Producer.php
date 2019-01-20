<?php

/* This is a rabbiMQ Producer Class for sending requests to RabbitMQ
 * Use this class to initiate the Queue to the Rabbit Application
 * Written by: UCC:Charles Mhoja
 */
namespace common\rabbit;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Producer {

    public $server_ip; //abbit server IP/uri
    public $server_port; //rabbit server port
    public $username;
    public $password;
    protected $connection; ///keeos the connection details tothe rabbitMQ

    public function __construct($config = []) {
        parent::__construct($config);
    }

    /*
     * connects to the RabbitMQ and sets the connection 
     */

    public function connect() {
        $this->connection = AMQPStreamConnection($this->server_ip, $this->server_port, $this->username, $this->password);
    }

    /*
     * creates a queue and send it to the RabbitMQ
     */

    public static function createQueue($queueName, $arrayData) {
        $channel = $this->connection->channel();
        $channel->queue_declare($queueName, false, true, false, false);
        $msg = new AMQPMessage(json_encode($arrayData), array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
        $channel->basic_publish($msg, '', $queueName);
        $channel->close();
    }

    /*
     * close a conenction on the RabbitMQ
     */

    public function closeConnection() {
        return $this->connection->close();
    }

}
