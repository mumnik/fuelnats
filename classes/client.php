<?php
/**
 * Created by PhpStorm.
 * User: dayan
 * Date: 08/01/2018
 * Time: 00:31
 */

namespace Fuelnats;

class Client {

    /**
     * @var \Nats\Connection
     */
    private static $instance = null;

    public static function forge($channel = null) {
        if (!self::$instance) {

            $encoder = new \Nats\Encoders\JSONEncoder();
            $options = new \Nats\ConnectionOptions();

            self::$instance = new \Nats\EncodedConnection($options, $encoder);
            self::$instance->connect();
        }
    }

    /**
     * @param string $channel
     * @param callable $callback
     */
    public static function subscribe($channel, $callback) {

        self::forge();

        self::$instance->subscribe($channel, $callback);
    }


    /**
     * @param int $numberOfMessages
     */
    public static function wait($numberOfMessages) {

        self::forge();

        self::$instance->wait($numberOfMessages);
    }

    /**
     * @param string $channel
     * @param array $data
     * @throws \Nats\Exception
     */
    public static function publish($channel, array $data) {

        self::forge();

        self::$instance->publish($channel, $data);
    }

    /**
     * @param string $channel
     * @param array $data
     * @param callable $callback
     */
    public static function request($channel, array $data, $callback) {

        self::forge();

        self::$instance->request($channel, $data, $callback);
    }
}