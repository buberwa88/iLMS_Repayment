<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace frontend\modules\application\rabbit;


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Producer{
    
    public static function queue($queueName, $arrayData){
     
        $connection = new AMQPStreamConnection('41.59.225.155', 5672, 'admin', 'admin');
        
        $channel = $connection->channel();
        
        $channel->queue_declare($queueName, false, true, false, false);
        
        $msg = new AMQPMessage(json_encode($arrayData),
                    array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
        
        $channel->basic_publish($msg, '', $queueName);
        
        $channel->close();
        
        $connection->close();   
    }
}
