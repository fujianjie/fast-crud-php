<script id="<?php echo $id;?>" name="<?php echo $name?>" type="text/plain"><?php echo $value?></script>
<script  type="text/javascript">
    var ueWidth = parseInt($(window).width() *0.765);
</script>
<?php
    if(!isset($GLOBALS['ueInclude'])){
        $GLOBALS['ueInclude'] = true;
        ?>
        <script type="text/javascript" src="/static/ue/ueditor.config.js"></script>
        <script type="text/javascript" src="/static/ue/ueditor.all.js"></script>
        <?php
    }
?>
<script type="text/javascript">


    var ue<?php echo $id;?> = UE.getEditor('<?php echo $id;?>');
</script>
