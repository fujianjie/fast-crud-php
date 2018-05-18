<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <?php $this->load->view('common/meta'); ?>
        <?php
        $staticUrl = TpSystem::getParam('staticurl');
        ?>
        <link rel="stylesheet" href="<?php echo $staticUrl; ?>/static/css/dashboard.css"/>
    </head>
    <body>

    </body>
</html>
