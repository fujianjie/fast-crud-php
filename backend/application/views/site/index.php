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

    <div class="container-fluid">
        <div class="row">
            <?php
                $this->load->view('common/sidebar');
            ?>
            <?php
                $this->load->view('common/topnav');
            ?>
            <iframe class="main" id="iframe" width="100%" height="100%" name="iframe" frameborder="0" scrolling="no"
                    src="<?php echo $nowUrl; ?>"></iframe>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="modal" id="bgModal"></div>
    <?php $this->load->view('common/photoswipe'); ?>
    </body>
    </html>
    <script>
        var intvalFunctions = [];
        $(document).ready(function () {
            setNavInit();
            $("body").resetPageWH();
            $(window).resize(function () {
                $("body").resetPageWH();
            });
        });
    </script>

<script type="text/javascript">
    if(intvalFunctions.length > 0){
        function runInterval(){
            for(var i  in intvalFunctions){
                eval(intvalFunctions[i]);
            }
        }
        var setRun = setInterval("runInterval();",60000);
        runInterval();
    }
</script>
