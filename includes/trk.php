<?php

namespace PPN;

// disable file editing
defined('ABSPATH') or die('Please do not edit!');

/**
 * Tracking class for the PPN plugin. Track data to a service.
 *
 * @package PPN
 * @since 4.3.1
 */
class TRK{

    /**
     * Google analytics ID.
     *
     * @access protected
     * @var string
     */
    private static $tid = 'UA-1825499-106';

    /**
     * Unique User ID.
     *
     * @access protected
     * @var string
     */
    private static $uuid;

    /**
     * Sends a dataset to a tracking service.
     *
     * @param array $payload Array of data to send to the tracking service
     */
    public static function track($payload = array()){
        // set the uuid
        if(! self::$uuid){
            self::$uuid = self::generate_uuid();
        }

        // create a new HTTP request
        $request = new \WP_Http();

        // parameters to send
        $params = array(
            'v' => '1',
            'tid' => self::$tid,
            'cid' => self::$uuid,
            't' => 'event'
        );

        // perform the request
        $result = $request->request('https://ssl.google-analytics.com/collect', array('method' => 'POST', 'body' => array_merge($params, $payload)));
    }

    /**
     * Generates a unique user id.
     *
     * @return string A randomly generated unique user id
     */
    private function generate_uuid(){
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}