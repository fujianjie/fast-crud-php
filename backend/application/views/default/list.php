<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
if (!$listAjaxPage) {
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view('common/meta'); ?>
</head>
<body class="inframe">
<div class="container-fluid inframe">
    <?php $this->load->view('msg/info'); ?>
    <div class="page-header row" id="page-header">
        <div class="col-sm-12 list-name">
            <h3 class="m-top-0">
                <?php
                echo $controllerName;
                if (!empty($listTitleSmall)) {
                    echo '<small>' . $listTitleSmall . '</small>';
                }
                ?>
            </h3>
            <?php
            if (isset($referer)) {
                ?>
                <a href="<?php echo $referer; ?>" class="btn btn-default prevPage">返回上一页</a>
                <?php
            }
            ?>
        </div>
        <div class="clearfix"></div>


        <?php
        if ($searchType == 'total') {
            ?>
            <div class="searchBlock" style="max-width:400px">
                <form class="form-horizontal" method="post" action="/<?php echo $className ?>/index"
                      name="data-form" id="data-form">
                    <?php echo TpCsrf::hidden(); ?>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" value="<?php echo $search; ?>">
                        <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><span
                                            class="glyphicon glyphicon-search"></span> 搜索</button></span>
                        <?php
                        if (!empty($search)) {
                            ?>
                            <span class="input-group-btn">
                                                                                        <a class="btn btn-default"
                                                                                           title="重置"
                                                                                           href="/<?php echo $className ?>/index?clearSearch=1"
                                                                                           type="submit">重置</a>
                                                                                </span>
                            <?php
                        }
                        ?>
                    </div><!-- /input-group -->
                </form>
            </div>
            <div class="clearfix"></div>
        <?php } ?>



        <?php if ($searchType == 'key') { ?>
            <div class="row listKeySearch searchBlock">
                <form class="form-horizontal" method="post" action="/<?php echo $className ?>/index"
                      name="data-form" id="data-form">
                    <?php echo TpCsrf::hidden(); ?>
                    <div class="col-sm-10 no-padding">
                        <?php
                        $keyAddDefault = $search;
                        foreach ($searchKey as $eachKey) {
                            $formInputName = 'TpForm::' . $keyTypeList[$eachKey];
                            if (empty($keyAddDefault) || !isset($keyAddDefault[$eachKey])) {
                                $default = '';
                            } else {
                                $default = $keyAddDefault[$eachKey];
                            }

                            if (empty($keySelectData) || !isset($keySelectData[$eachKey])) {
                                $selectData = '';
                            } else {
                                $selectData = $keySelectData[$eachKey];
                            }
                            if (empty($keyNeed) || !isset($keyNeed[$eachKey])) {
                                $need = true;
                            } else {
                                $need = $keyNeed[$eachKey];
                            }

                            if (is_callable('TpForm', $keyTypeList[$eachKey])) {
                                $str = TpForm::$keyTypeList[$eachKey]($keyNameList[$eachKey], $eachKey, $default, $selectData, $need);
                                $str = str_replace('col-sm-3', 'col-sm-5', $str);
                                $str = str_replace('col-sm-9', 'col-sm-7', $str);
                                echo $str;
                            } else {
                                echo "<div class=\"form-group\"><p>{$formInputName} not exist</p></div>";
                            }
                            echo "\n";
                        }
                        ?>
                    </div>
                    <div class="col-sm-2 text-right no-padding">
                                                                        <span class="input-group-btn">
                                                                                <button type="submit"
                                                                                        class="btn btn-default"> 搜索
                                                                                </button>

                                                                            <?php
                                                                            $emptySearch = true;
                                                                            if (is_array($search)) {
                                                                                foreach ($search as $e) {
                                                                                    if ($e === 0) {
                                                                                        $emptySearch = false;
                                                                                        continue;
                                                                                    }
                                                                                    if (!empty($e)) {
                                                                                        $emptySearch = false;
                                                                                    }
                                                                                }
                                                                            }
                                                                            if (!$emptySearch) {
                                                                            ?>
                                                                            <a class="btn btn-default" title="重置"
                                                                               href="/<?php echo $className ?>/index?clearSearch=1"
                                                                               type="submit">重置</a>
                                                                                </span>
                        <?php
                        }
                        ?>
                    </div>
                </form>
            </div>
        <?php } ?>
        <?php
        if ($searchHide) {
            echo "<style>.searchBlock{display:none;}</style>";
        }
        echo $searchAddonContent;
        ?>
    </div><!--<div class="page-header row"> end -->
    <?php
    if ($searchType == 'searchPage') {
        echo '<ul class="listSearchPageData">';
        if (count($searchData) > 0) {
            foreach ($searchData as $k => $v) {
                ?>
                <li class="col-sm-4">
                    <label><?php echo $keyNameList[$k]; ?>：</label>
                    <span>
                         <?php
                                                                        if (in_array($keyTypeList[$k], $needChangeType)) {
                                                                            $fname = $keyTypeList[$k] . 'Value';
                                                                            echo TpForm::$fname($searchData[$k], $keySelectData[$k]);
                                                                        } else {
                                                                            echo $searchData[$k];
                                                                        }
                                                                        ?>
                                                                </span>
                </li>

                <style>
                    .listSearchPageData {
                        width: 80%;
                        float: left;
                        line-height: 34px;
                    }

                    .listSearchPageData li.col-sm-4 {
                        padding-left: 0;
                        padding-right: 0;
                    }

                    #addLinkBlock {
                        width: 20%;
                        float: right;
                    }
                </style>
                <?php
            }

        }
        ?>
        <li>
                                                <span class="input-group-btn">
                                                                                        <a class="btn btn-default"
                                                                                           title="重置"
                                                                                           href="/<?php echo $className ?>/index?clearSearch=1"
                                                                                           type="submit">重置</a>
                                                                                </span>
        </li>
        <div class="clearfix"></div>
        <?php
        echo '</ul>';
    }
    ?>
    <div class="text-right" id="addLinkBlock">
        <?php

        if ($exportExcelOpen) {
            $hasSearch = false;
            if ($searchType == 'total') {
                $hasSearch = !empty($search);
            } else if ($searchType == 'key') {
                $hasSearch = !$emptySearch;
            } else if ($searchType == 'searchPage') {
                $hasSearch = count($hasSearch) > 0;
            }

            $idStr = '';
            if ($emptySearch === false) {
                $idArray = array();
                if (count($listData) > 0) {
                    foreach ($listData as $each) {
                        $idArray[] = $each['id'];
                    }
                }

                if (count($idArray) > 0) {
                    $idStr = urlencode(implode(',', $idArray));
                }
            }

            ?>

            <a href='/<?php echo $className ?>/exportExcel?dontsaveurl=1&lastLink=<?php echo urlencode($nowUrl); ?>&<?php echo $exportUrl; ?>'
               class='btn btn-info' targert="_blank" id="exportLink">导出</a>

            <?php
        }
        if ($addOpen && $editAccess) {
            if (!empty($listAddButton)) {
                echo $listAddButton;
            } else {
                ?>
                <a href='/<?php echo $className ?>/add?clearAutoFill=1&dontsaveurl=1&lastLink=<?php echo urlencode($nowUrl); ?>'
                   class='btn btn-info ' id="addLink"> 新增</a>

                <?php
            }
        }
        if ($searchPageOpen && $searchType == 'key') {
            ?>

            <a href='/<?php echo $className ?>/search' class='btn btn-info '> 综合搜索</a>
            <?php
            if ($searchType == 'searchPage') {
                ?>
                <a class="btn btn-danger" title="重置" href="/<?php echo $className ?>/index?clearSearch=1"
                   type="submit"> 重置</a>
                <?php
            }
            ?>
            <?php
        }
        ?>
    </div>
    <div class="clearfix"></div>
    <?php
    }
    if (isset($listSql) && !empty($listSql)) {
        echo "<pre>{$listSql}</pre>";
    }
    ?>

    <div class="listTable" id="listTableDiv">
        <?php
        if (!empty($listNavHtml) && !$listAjaxPage) {
            echo $listNavHtml;
        }
        ?>
        <table id="listTable" class="table table-bordered table-hover <?php
        if ($listNoBorder) {
            echo "td-no-border";
        }
        ?>">
            <thead>
            <tr>
                <?php
                if (count($listKey) > 0) {
                    foreach ($listKey as $v) {
                        echo "<th>{$keyNameList[$v]}";
                        if (in_array($v, $listSortKey) && !$listAjaxPage && $listSortOpen) {
                            echo "<span class='glyphicon glyphicon-sort' node='listSort' sortKey='{$v}' ></span>";
                        }
                        echo "</th>";
                    }
                }
                if ($listOperation) {
                    if ($addonButton) {
                        echo '<th  class="opt">操作 ';
                    } else {
                        echo '<th width="150" class="opt">操作 ';
                    }
                    if (!$listAjaxPage && $optToggle) {
                        echo '<button type="button" id="optToggle" class="btn btn-xs btn-info"> <span class="glyphicon glyphicon-arrow-right"></span></button>';
                    }
                    echo '</th>';
                }
                ?>

            </tr>
            </thead>
            <tbody>
            <?php
            if (count($listData) > 0) {
                foreach ($listData as $each) {
                    echo "<tr>";
                    $deleteContent = '';
                    foreach ($listKey as $k) {

                        $important = '';
                        if (in_array($k, $keyImportant)) {
                            $important = 'class="important"';
                        }
                        if (in_array($keyTypeList[$k], $needChangeType)) {
                            $fname = $keyTypeList[$k] . 'Value';
                            $show = TpForm::$fname($each[$k], $keySelectData[$k]);
                            if ($k != $primaryKey && $deleteContent == '') {
                                $deleteContent = $show;
                            }

                            echo "<td $important>" . $show . "</td>";
                        } else {
                            if ($k != $primaryKey && $deleteContent == '') {
                                $deleteContent = $each[$k];
                            }
                            echo "<td $important>{$each[$k]}</td>";
                        }
                    }
                    $deleteContent = strip_tags($deleteContent);
                    if ($listOperation) {
                        echo "<td class=\"important option\">";
                        if ($detailOpen) {
                            $detailUrl = "/{$className}/detail?{$primaryKey}=$each[$primaryKey]";
                            ?>

                            <a href="<?php echo $detailUrl; ?>" class="btn btn-default" title="详细">详细</a>
                            <?php
                        }
                        if ($addonButton) {
                            echo $addonButton[$each[$primaryKey]];
                        }
                        if (isset($each['editOpen'])) {
                            $editOpen = $each['editOpen'];
                        }
                        if ($editAccess && $editOpen) {
                            $editUrl = '/' . $className . '/edit?' . $primaryKey . '=' . $each[$primaryKey];
                            if (!$listAjaxPage) {
                                $editUrl .= '&lastLink=' . urlencode($nowUrl);
                            }
                            if ($isAjaxPage) {
                                $editUrl = 'javascript:$("body").editModal("' . $className . '","edit","' . $each[$primaryKey] . '");';
                            }
                            ?>
                            <a href='<?php echo $editUrl; ?>'
                               class="btn btn-info" title="编辑">编辑</a>
                            <?php
                        }
                        if (isset($each['removeOpen'])) {
                            $removeOpen = $each['removeOpen'];
                        }
                        if ($deleteAccess && $removeOpen) {
                            $removeUrl = "/{$className}/remove?{$primaryKey}={$each[$primaryKey]}";
                            if ($isAjaxPage) {
                                $removeUrl = 'javascript:$(\'body\').removeModal(\'' . $className . '\',\'remove\',\'' . $each[$primaryKey] . '\')';
                            }
                            ?>
                            <a href="<?php echo $removeUrl; ?>"
                               class="btn btn-warning list-delete" contentname="<?php echo $deleteContent; ?>"
                               title="删除">删除</a>
                            <?php
                        }
                        echo "</td>";
                    }
                    echo "</tr>";
                }
            }
            ?>

            </tbody>
        </table>
    </div>
    <script>
        var sortKey = "<?php echo $orderBy; ?>";
        var sortWay = "<?php echo $orderWay; ?>";
        var baseUrl = "<?php echo $baseUrl; ?>";
        $(document).ready(function () {
            $("span[node=listSort]").css('cursor', 'pointer').bind('click', function () {
                var key = $(this).attr('sortKey');
                if (sortKey == key) {
                    if (sortWay == 'DESC') {
                        sortWay = 'ASC';
                    } else if (sortWay == 'ASC') {
                        sortWay = 'DESC';
                    }
                }

                function addParam(baseUrl, name, value) {
                    if (/\?/g.test(baseUrl)) {
                        if (/name=[-\w]{4,25}/g.test(baseUrl)) {
                            baseUrl = baseUrl.replace(/name=[-\w]{4,25}/g, name + "=" + value);
                        } else {
                            baseUrl += "&" + name + "=" + value;
                        }
                    } else {
                        baseUrl += "?" + name + "=" + value;
                    }
                    return baseUrl;
                }

                var url = addParam(baseUrl, 'orderBy', key);
                url = addParam(url, 'orderWay', sortWay);
                //console.log(url);return;
                self.location.href = url;
            });
            //console.log(sortWay);
            $("span[sortKey=" + sortKey + "]").css('color', '#5bc0de');
            <?php if(!$isAjaxPage){?>
            $("body").listDelete();
            <?php }?>
            $("body").listResetWidth('hidecol');
            <?php
            if (isset($listScript)) {
                echo $listScript;
            }
            ?>
        });
    </script>
    <?php
    if (!$listAjaxPage) {
    if ($listOperation) {
        echo $page;
    }
    ?>
</div>
<?php $this->load->view('common/delModal'); ?>


<?php $this->load->view('common/iframefooter'); ?>
</body>
</html>
    <script>
        $(document).ready(function () {

            if (self != top) {
                parent.setNav('<?php echo empty($navName) ? $controllerName : $navName; ?>');
            }


            <?php if ($addOpen) { ?>
            $(window).bind('keyup', function (event) {

                if (event.originalEvent.keyCode !== undefined) {
                    var code = event.originalEvent.keyCode;

                    if (code == 107) {
                        var href = ($("#addLink").attr('href'));
                        self.location.href = href;
                    }
                }
            });

            <?php } ?>

            $("#optToggle").bind('click', function () {
                var btn = $("tr").find('td.option').find('a');
                var span = $(this).find('span');
                var toggleStatus = span.hasClass('glyphicon-arrow-right');

                if (toggleStatus) {
                    btn.each(function () {
                        if ($(this).find('span').hasClass('glyphicon-search')) {

                        } else {
                            $(this).hide();
                        }
                    });
                    span.removeClass('glyphicon-arrow-right').addClass('glyphicon-arrow-left');
                } else {
                    btn.each(function () {
                        if ($(this).find('span').hasClass('glyphicon-search')) {

                        } else {
                            $(this).show();
                        }
                    });
                    span.removeClass('glyphicon-arrow-left').addClass('glyphicon-arrow-right');
                }
                $("body").listResetWidth('hidecol')
            });

            var thLength = $("#listTable").find('th').length;
            if ($("#listTable").width() < 1200 && thLength > 5) {
                if ($('th.opt:eq(0)').width() > 120) {
                    $("#optToggle").click();
                }

            }
        });
    </script>
<?php
}
?>
