<?php $this->load->view('common/photoswipe'); ?>
<script>
        function resetHeight() {
                var parentIframe = parent.$('#iframe');
                var height = $('body').height();
                var pheight = $(parent.window).height();
                var setHeight = parseInt(pheight) - 100;
                if (setHeight > height) {
                        height = setHeight;
                }
                if ($(parent.window).width() < 415) {
                        pheight = $(parent.window).height() - parent.$(".navbar-header").height();
                        if (height < pheight) {
                                height = pheight - 7;
                        }
                }
                parentIframe.height(height);

        }
        var runResetHeightInterval;
        $(document).ready(function () {
                if (self != top) {
                        resetHeight();
                        $(window).resize(function () {
                                resetHeight();
                        });
                        parent.$('body,html').animate({scrollTop: 0}, 'fast');
                        runResetHeightInterval = setInterval('resetHeight()', 300);
                }
        });
</script>