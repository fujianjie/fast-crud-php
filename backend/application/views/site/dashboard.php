<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
        <head>
                <?php $this->load->view('common/meta'); ?>
        </head>
        <body>
                <div class="container-fluid inframe">
                        <?php $this->load->view('msg/info'); ?>
                        <div class="page-header row">
                                <div class="col-md-6 col-xs-6">
                                        <h3 class="m-top-0">欢迎进入本系统</h3>
                                </div>
                        </div>
                        <div>
                                <div id="map">
                                       
                                </div>
                        </div>
                </div>
        </body>
</html>
<?php $this->load->view('common/iframefooter'); ?>
<style>
        #map{width: 800px; height: 563px; margin: 0px auto; position: relative;}
        body{background: #fff;}

</style>