<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-03-03
 * Time: 11:38 AM
 */

    // still very much a work in progress
    // 2015-03:  currently using 'email_sender' & 'production'
    //              images are ALWAYS on production server (will be fixed by 'image_host' - eventually)

    // dev setting for default sender of emails
    $config['dac']['email_sender'] = 'rod.bray@scottambler.com';
    // production setting
    //$config['dac']['email_sender'] = 'admin@disciplinedagileconsortium.org';

    // dev setting for location of icons & images
    $config['dac']['image_host'] = 'localhost';
    // production setting
    //$config['dac']['image_host'] = 'localhost';

    // environment indicator
    // controls things such as appearance of SQL Query log in default.ctp
    $config['dac']['production'] = false; //  when in dev  // true;   when deploying


?>