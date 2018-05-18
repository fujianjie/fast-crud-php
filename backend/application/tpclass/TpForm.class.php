<?php

/**
 * 表单构造器
 * @version 0.1
 */
class TpForm
{



    static public function hrFirst($name, $kname, $value, $selectData = array(), $isNeeded = 0)
    {
        $GLOBALS['hropen'] = true;
        $a = '';
        $num = 0;
        if (count($selectData) > 0 && is_array($selectData)) {

            foreach ($selectData as $each) {

                if (isset($each['link']) && isset($each['name'])) {

                    $style = "style=\"right:{$num}px\"";
                    $a .= "<a class=\"btn btn-info\" href=\"{$each['link']}\"  {$style} >{$each['name']}</a>\n";
                    $num += 100;
                } else {
                    if (isset($each['html'])) {
                        $a .= $each['html'];
                    }
                }
            }
        }
        $html = '<div class="hrInfo"><h5  name="' . strip_tags($name) . '">' . $name . '</h5>' . $a . '</div>';
        $html .= "<div class=\"hrBlock\">";
        return $html;
    }

    static public function hrFirstValue($value, $selectData)
    {
        $GLOBALS['hropen'] = true;
        $a = '';
        $num = 0;
        if (count($selectData) > 0 && is_array($selectData)) {
            foreach ($selectData as $each) {
                if (isset($each['link']) && isset($each['name'])) {

                    $style = "style=\"right:{$num}px\"";
                    $a .= "<a class=\"btn btn-info\" href=\"{$each['link']}\" {$style} >{$each['name']}</a>\n";
                    $num += 100;
                } else {
                    if (isset($each['html'])) {
                        $a .= $each['html'];
                    }
                }
            }
        }
        $html = '<div class="hrInfo"><h5  name="' . $value . '">' . $value . '</h5>' . $a . '</div>';
        $html .= "<div class=\"hrBlock\">";
        return $html;
    }

    static public function hr($name, $kname, $value, $selectData, $isNeeded = 0)
    {
        $html = '';
        if (isset($GLOBALS['hropen']) && $GLOBALS['hropen']) {
            $html .= "<div class='clearfix'></div></div>";
        }
        $a = '';
        if (count($selectData) > 0 && is_array($selectData)) {
            foreach ($selectData as $each) {
                if (isset($each['link']) && isset($each['name'])) {
                    $a .= "<a class=\"btn btn-info\" href=\"{$each['link']}\" >{$each['name']}</a>\n";
                } else {
                    if (isset($each['html'])) {
                        $a .= $each['html'];
                    }
                }
            }
        }
        $html .= '<div class="hrInfo"><h5 name="' . $name . '">' . $name . '</h5>' . $a . '</div>';
        //	$html .= '<h4  class="hr">' . $name . '</h4><hr/>';
        $html .= "<div class=\"hrBlock\">";
        return $html;
    }

    static public function hrValue($value, $selectData)
    {
        $html = '';
        if (isset($GLOBALS['hropen']) && $GLOBALS['hropen']) {
            $html .= "<div class='clearfix'></div></div>";
        }
        $a = '';
        if (count($selectData) > 0 && is_array($selectData)) {
            foreach ($selectData as $each) {
                if (isset($each['link']) && isset($each['name'])) {
                    $a .= "<a class=\"btn btn-info\" href=\"{$each['link']}\" >{$each['name']}</a>\n";
                } else {
                    if (isset($each['html'])) {
                        $a .= $each['html'];
                    }
                }

            }
        }
        $html .= '<div class="hrInfo"><h5  name="' . $value . '">' . $value . '</h5>' . $a . '</div>';
        $html .= "<div class=\"hrBlock\">";
        return $html;
    }


    /**
     * 表单高级元素
     * 关联用户
     */
    static public function user($name, $kname, $value, $selectData, $isNeeded = 0)
    {
        $CI = &get_instance();
        $CI->load->model('TotalUserData');
        $options = "<option value=\"\">请选择</option>";
        if (!empty($value)) {
            $zname = $CI->TotalUserData->searchName($value);
            if (!empty($zname)) {
                $options .= "<option value=\"$value\" selected=\"selected\">{$zname}</option>";
            }
        }
        $html = '<div class="form-group searchSelect"><label class="col-sm-3 control-label" >' . $name . '：</label><div class="col-sm-9"><div class="col-sm-12">';
        $html .= '<div class="col-sm-6"><select class="form-control" name="' . $kname . '" selectType="userSearch">' . $options . '</select></div>';
        $html .= '<div class="col-sm-6"><input type="text" class="form-control" name="temp-zuhuSearch" selectType="userSearch" placeholder="姓名，手机查找"></div>';
        $html .= '<p class="col-sm-12 error-msg"></p></div></div>';
        $html .= '<script>$(document).ready(function(){$("body").userSearch();});</script></div>';
        return $html;
    }

    /**
     * 表单高级元素
     * 关联用户
     */
    static public function userValue($value, $selectData)
    {
        $CI = &get_instance();
        $CI->load->model('TotalUserData');
        if (!empty($value)) {
            $data = $CI->TotalUserData->getIdData($value);
            $name = $data['realname'] . '&nbsp;&nbsp;&nbsp;' . $data['mobile'];
            return $name;
        } else {
            return '';
        }
    }

    static public function bool($name, $kname, $value, $selectData, $isNeeded = 0)
    {
        if (!is_array($selectData)) {
            $selectData = trim($selectData);
        }

        if (!empty($selectData) || count($selectData) > 0) {
            return self::radio($name, $kname, $value, $selectData, $isNeeded);
        } else {
            $selectData = array(0 => '否', 1 => '是');
            return self::radio($name, $kname, $value, $selectData, $isNeeded);
        }
    }

    static public function boolValue($value, $selectData)
    {
        if (empty($selectData) || count($selectData) == 0) {
            $selectData = array(0 => '否', 1 => '是');
        }
        if (isset($selectData[$value])) {
            return $selectData[$value];
        } else {
            return $value;
        }
    }

    static public function radio($name, $kname, $value, $selectData, $isNeeded = 0)
    {
        $html = '<div class="form-group"><label class="col-sm-3 control-label" for="form-' . $kname . '">' . $name . '：</label><div class="col-sm-9"><div class="col-sm-12">';
        if (count($selectData) > 0 && is_array($selectData)) {
            foreach ($selectData as $k => $v) {
                $checked = '';
                if ($k == $value) {
                    $checked = 'checked="checked" ';
                }
                $html .= '<label class="radio-inline"><input type="radio" name="' . $kname . '"  value="' . $k . '" ' . $checked . '> ' . $v . '</label>';
            }
        }
        $html .= '</div><p class=" col-sm-12 error-msg"></p></div></div>';
        return $html;
    }

    static public function radioValue($value, $selectData)
    {
        if (isset($selectData[$value])) {
            return $selectData[$value];
        } else {
            return $value;
        }
    }

    static public function number($name, $kname, $value, $selectData, $isNeeded = 0)
    {
        $html = '<div class="form-group"><label class="col-sm-3 control-label" for="form-' . $kname . '">' . $name . '：</label><div class="col-sm-9"><div class="col-sm-12"><input type="number" name="' . $kname . '" placeholder="" class="form-text form-control" id="form-' . $kname . '" value="' . $value . '"/></div><p class=" col-sm-12 error-msg"></p></div></div>';
        return $html;
    }

    static public function file($name, $kname, $value, $selectData, $isNeeded = 0)
    {
        $html = '<div class="form-group fileInput"><label class="col-sm-3 control-label" for="form-' . $kname . '">' . $name . '：</label>';
        $html .= '<div class="col-sm-9">';
        $html .= '<div class="col-sm-4"><input type="file" id="' . $kname . '" name="onefile" placeholder="" class="form-text form-control" id="form-' . $kname . '"  /> </div>';

        $html .= '<div class="col-sm-4 text-right"><button type="button" class="btn btn-info" node="' . $kname . '"><span class="glyphicon glyphicon-cloud-upload"></span> 上传</button></div>';
//$html .= '<p class=" col-sm-9 error-msg " error="' . $kname . '"></p>';
        $html .= "<ul class=\"fileGallery  col-sm-9\" node=\"{$kname}\">";

        if ($value != '') {
            $CI = &get_instance();
            $CI->load->model('FilesData');
            $sourcename = $CI->FilesData->sourcename($value);
            $html .= "<li><a href=\"{$value}\" class=\"fileLink\"  sourcename=\"{$sourcename}\"><span class=\"glyphicon glyphicon-file\"></span>{$sourcename}</a>";
            $html .= "<input type=\"hidden\" name=\"{$kname}\" value=\"{$value}\" /></li>\n";
        }
        $html .= "</ul>";
        $html .= '</div></div>';
        $html .= "\n";
        $html .= '<script>$(document).ready(function(){$("body").uploadFile("' . $kname . '");});</script>';
        return $html;
        return $value;
    }

    static public function aValue($value, $selectData)
    {
        return "<a href=\"{$value}\" target=\"_blank\" >{$value}</a>";
    }

    static public function fileValue($value, $selectData)
    {
        $CI = &get_instance();
        $CI->load->model('FilesData');

        $html = "<ul class=\"fileGallery  col-sm-9\" >";
        if (!empty($value)) {
            $sourcename = $CI->FilesData->sourcename($value);
            $html .= "<li><a href=\"{$value}\" target=\"_blank\" class=\"fileLink\"  sourcename=\"{$sourcename}\"><span class=\"glyphicon glyphicon-file\"></span>{$sourcename}</a></li>\n";
        }
        $html .= "</ul>\n";
//$html.='<script>$(document).ready(function(){$("body").uploadFilesArray($("ul.imageGallery"));});</script>';
        $html .= "\n";
        return $html;
    }

    static public function filesValue($value, $selectData)
    {
        $CI = &get_instance();
        $CI->load->model('FilesData');

        $html = "<ul class=\"fileGallery  col-sm-9\" >";
        if ($value != '') {
            $sourcename = $CI->FilesData->sourcename($value);
            $valueArray = explode(',', $value);
            if (count($valueArray) > 0) {
                foreach ($valueArray as $each) {
                    $sourcename = $CI->FilesData->sourcename($each);
                    $html .= "<li><a href=\"{$each}\" target=\"_blank\" class=\"fileLink\"  sourcename=\"{$sourcename}\"><span class=\"glyphicon glyphicon-file\"></span>{$sourcename}</a></li>\n";
                }
            }
        }

        $html .= "</ul>\n";
//$html.='<script>$(document).ready(function(){$("body").uploadFilesArray($("ul.imageGallery"));});</script>';
        $html .= "\n";
        return $html;
    }

    static public function files($name, $kname, $value, $selectData, $isNeeded = 0)
    {
        $html = '<div class="form-group fileInput"><label class="col-sm-3 control-label" for="form-' . $kname . '">' . $name . '：</label>';
        $html .= '<div class="col-sm-9">';
        $html .= '<div class="col-sm-4"><input type="file" id="' . $kname . '" name="filesArray[]" multiple  placeholder="" class="form-text form-control" id="form-' . $kname . '"/></div>';
        $html .= '<div class="col-sm-4 text-right"><button type="button" class="btn btn-info" node="' . $kname . '"><span class="glyphicon glyphicon-cloud-upload"></span> 上传</button> </div>';
//$html .= '<p class=" col-sm-9 error-msg"  error="' . $kname . '"></p>';
        $html .= "<ul class=\"fileGallery  col-sm-9\" node=\"{$kname}\">";

        if ($value != '') {
            $CI = &get_instance();
            $CI->load->model('FilesData');
            $valueArray = explode(',', $value);
            if (count($valueArray) > 0) {
                foreach ($valueArray as $each) {
                    $sourcename = $CI->FilesData->sourcename($each);
                    $html .= "<li><a href=\"{$each}\" target=\"_blank\" class=\"fileLink\"  sourcename=\"{$sourcename}\"><span class=\"glyphicon glyphicon-file\"></span>{$sourcename}</a>";
                    $html .= "<input type=\"hidden\" name=\"{$kname}[]\" value=\"{$each}\" /></li>\n";
                }
            }
        }
        $html .= "</ul>";
        $html .= '</div></div>';
        $html .= "\n";
        $html .= '<script>$(document).ready(function(){$("body").uploadFilesArray("' . $kname . '");});</script>';
        return $html;
    }

    static public function date($name, $kname, $value, $selectData, $isNeeded = 0)
    {
        $html = '<div class="form-group"><label class="col-sm-3 control-label" for="form-' . $kname . '">' . $name . '：</label><div class="col-sm-9"><div class="col-sm-12"><input type="date" name="' . $kname . '" placeholder="" class="form-text form-control" id="form-' . $kname . '" value="' . $value . '"/></div><p class=" col-sm-12 error-msg"></p></div></div>';
        return $html;
    }

    static public function datetime($name, $kname, $value, $selectData, $isNeeded = 0)
    {
        if (!empty($value)) {
            $time = strtotime($value);
            $value = date("Y-m-d", $time) . 'T' . date('h:i:s', $time);
        }
        $html = '<div class="form-group"><label class="col-sm-3 control-label"  for="form-' . $kname . '">' . $name . '：</label><div class="col-sm-9"><div class="col-sm-12"><input type="datetime-local" v="' . $value . '" name="' . $kname . '" placeholder="" class="form-text form-control" id="form-' . $kname . '" value="' . $value . '"/></div><p class=" col-sm-12 error-msg"></p></div></div>';
        return $html;
    }

    static public function textarea($name, $kname, $value, $selectData, $isNeeded = 0)
    {
        $html = '<div class="form-group form-textarea"><label class="col-sm-3 control-label" for="form-' . $kname . '">' . $name . '：</label><div class="col-sm-9"><div class="col-sm-12"><textarea class="form-control" rows="5" name="' . $kname . '" id="form-' . $kname . '">' . $value . '</textarea></div><p class=" col-sm-12 error-msg"></p></div></div><div></div>';
        return $html;
    }

    /**
     * html 在线编辑器
     *
    */
    static public function htmlEditor($name, $kname, $value, $selectData, $isNeeded = 0){
        $CI = &get_instance();
        $ueHtml = $CI->load->view('default/ue',array('id'=>'form_'.$kname,'name'=>$kname,'value'=>$value),true);
        $html = '<div class="form-group form-textarea"><label class="col-sm-3 control-label" for="form-' . $kname . '">' . $name . '：</label><div class="col-sm-9"><div class="col-sm-12">'.$ueHtml.'</div><p class=" col-sm-12 error-msg"></p></div></div><div></div>';
        return $html;
    }



    static public function select($name, $kname, $value, $selectData, $isNeeded = 0)
    {
        $options = "<option value=\"\">请选择</option>";
        if (is_numeric($value)) {
            $value = (int)$value;
        }
        if (is_array($selectData) && count($selectData) > 0) {
            foreach ($selectData as $k => $v) {
                if ($value === '') {
                    $options .= "<option value=\"$k\">{$v}</option>";
                    continue;
                }
                if (is_numeric($value) && is_numeric($k)) {
                    if ($k === $value) {
                        $options .= "<option value=\"$k\" selected=\"selected\">{$v}</option>";
                    } else {
                        $options .= "<option value=\"$k\" >{$v}</option>";
                    }
                    continue;
                }

                if ($value == $k) {
                    $options .= "<option value=\"$k\" selected=\"selected\">{$v}</option>";
                } else {
                    $options .= "<option value=\"$k\">{$v}</option>";
                }
            }
        }
        if ($isNeeded) {
            $name = "" . $name;
        }
        $html = '<div class="form-group"><label class="col-sm-3 control-label" >' . $name . '：</label><div class="col-sm-9"><div class="col-sm-12"><select class="form-control" name="' . $kname . '">' . $options . '</select><p class="col-sm-12 error-msg"></p></div></div></div>';
        return $html;
    }

    static public function selectValue($value, $selectData)
    {
        if (isset($selectData[$value])) {
            return $selectData[$value];
        } else {
            return $value;
        }
    }

    static public function image($name, $kname, $value = '', $selectData = '', $isNeeded = 0)
    {
        $html = '<div class="form-group imageInput"><label class="col-sm-3 control-label" for="form-' . $kname . '">' . $name . '：</label>';
        $html .= '<div class="col-sm-9">';
        $html .= '<div class="col-sm-4"><input type="file" id="' . $kname . '" name="image" placeholder="" class="form-text form-control" id="form-' . $kname . '" accept="image/jpeg,image/png,image/gif" /> </div>';

        $html .= '<div class="col-sm-4 text-right"><button type="button" class="btn btn-info" node="' . $kname . '"><span class="glyphicon glyphicon-cloud-upload"></span> 上传</button> <button style="display:none;" type="button" class="btn btn-info" gallery="' . $kname . '"><span class="glyphicon glyphicon-picture"></span> 查看</button></div>';
//$html .= '<p class=" col-sm-9 error-msg " error="' . $kname . '"></p>';
        $html .= "<ul class=\"imageGallery  col-sm-9\" node=\"{$kname}\">";

        if ($value != '') {
            $CI = &get_instance();
            $CI->load->model('FilesData');
            $sourcename = $CI->FilesData->sourcename($value);
            $html .= "<li><img src=\"{$value}\" sourcename=\"{$sourcename}\"/>";
            $html .= "<input type=\"hidden\" name=\"{$kname}\" value=\"{$value}\" /><p>{$sourcename}</p></li>\n";
        }
        $html .= "</ul>";
        $html .= '</div></div>';
        $html .= "\n";
        $html .= '<script>$(document).ready(function(){$("body").uploadImage("' . $kname . '");});</script>';
        return $html;
    }

    static public function imageValue($value, $selectData)
    {
        $CI = &get_instance();
        $CI->load->model('FilesData');

        $html = "<ul class=\"imageGallery  col-sm-9\" >";
        if (!empty($value)) {
            $sourcename = $CI->FilesData->sourcename($value);
            $html .= "<li><img src=\"{$value}\" sourcename=\"{$sourcename}\"/><p>{$sourcename}</p></li>\n";
        }
        $html .= "</ul>\n";
        $html .= '<script>$(document).ready(function(){$("body").bindViewGallery($("ul.imageGallery"));});</script>';
        $html .= "\n";
        return $html;
    }

    static public function images($name, $kname, $value = '', $selectData = '', $isNeeded = 0)
    {
        $html = '<div class="form-group imageInput"><label class="col-sm-3 control-label" for="form-' . $kname . '">' . $name . '：</label>';
        $html .= '<div class="col-sm-9">';
        $html .= '<div class="col-sm-4"><input type="file" id="' . $kname . '" name="imagesArray[]" multiple  placeholder="" class="form-text form-control" id="form-' . $kname . '" accept="image/jpeg,image/png,image/gif" /></div>';
        $html .= '<div class="col-sm-4 text-right"><button type="button" class="btn btn-info" node="' . $kname . '"><span class="glyphicon glyphicon-cloud-upload"></span> 上传</button> <button type="button" class="btn btn-info" gallery="' . $kname . '" style="display:none;"><span class="glyphicon glyphicon-picture"></span> 查看</button></div>';
//$html .= '<p class=" col-sm-9 error-msg"  error="' . $kname . '"></p>';
        $html .= "<ul class=\"imageGallery  col-sm-9\" node=\"{$kname}\">";

        if ($value != '') {
            $CI = &get_instance();
            $CI->load->model('FilesData');
            $valueArray = explode(',', $value);
            if (count($valueArray) > 0) {
                foreach ($valueArray as $each) {
                    if(empty($each)){
                        continue;
                    }
                    $sourcename = $CI->FilesData->sourcename($each);
                    if($sourcename === NULL){
                        continue;
                    }
                    $html .= "<li><img src=\"{$each}\" sourcename=\"{$sourcename}\"/>";
                    $html .= "<input type=\"hidden\" name=\"{$kname}[]\" value=\"{$each}\" /><p>{$sourcename}</p></li>\n";
                }
            }
        }
        $html .= "</ul>";
        $html .= '</div></div>';
        $html .= "\n";
        $html .= '<script>$(document).ready(function(){$("body").uploadImagesArray("' . $kname . '");});</script>';
        return $html;
    }

    static public function imagesValue($value, $selectData)
    {
        $CI = &get_instance();
        $CI->load->model('FilesData');
        $html = "<ul class=\"imageGallery  col-sm-9\" >";
        if ($value != '') {
            $valueArray = explode(',', $value);
            if (count($valueArray) > 0) {
                foreach ($valueArray as $each) {
                    $sourcename = $CI->FilesData->sourcename($each);
                    $html .= "<li><img src=\"{$each}\" sourcename=\"{$sourcename}\"/><p>{$sourcename}</p></li>\n";
                }
            }
        }
        $html .= "</ul>";
        $html .= '<script>$(document).ready(function(){$("body").bindViewGallery($("ul.imageGallery"));});</script>';
        return $html;
    }

    static public function hidden($name, $kname, $value = '', $selectData = '', $isNeeded = 0)
    {
        $html = '<input type="hidden" name="' . $kname . '" placeholder="" class="form-text form-control" id="form-' . $kname . '" value="' . $value . '"/>';
        return $html;
    }

    static public function shortText($name, $kname, $value = '', $selectData = '', $isNeeded = 0)
    {
        $html = '<div class="form-group"><label class="col-sm-3 control-label" for="form-' . $kname . '">' . $name . '：</label><div class="col-sm-9"><div class="col-sm-4"><input type="text" name="' . $kname . '" placeholder="" class="form-text form-control" id="form-' . $kname . '" value="' . $value . '"/></div><p class=" col-sm-12 error-msg"></p></div></div>';
        return $html;
    }

    static public function showText($name, $kname, $value = '', $selectData = '', $isNeeded = 0)
    {
        $html = '<div class="form-group"><label class="col-sm-3 control-label" for="form-' . $kname . '">' . $name . '：</label><div class="col-sm-9"><div class=\' text-left control-label\'>' . $value . '</div><p class=" col-sm-12 error-msg"></p></div></div>';
        return $html;
    }

    static public function middleText($name, $kname, $value = '', $selectData = '', $isNeeded = 0)
    {
        $html = '<div class="form-group"><label class="col-sm-3 control-label" for="form-' . $kname . '">' . $name . '：</label><div class="col-sm-9"><div class="col-sm-12"><input type="text" name="' . $kname . '" placeholder="" autocomplete="off" class="form-text form-control" id="form-' . $kname . '" value="' . $value . '"/></div><p class=" col-sm-12 error-msg"></p></div></div>';
        return $html;
    }

    static public function readonlyText($name, $kname, $value = '', $selectData = '', $isNeeded = 0)
    {
        $html = '<div class="form-group"><label class="col-sm-3 extraInput control-label" for="form-' . $kname . '">' . $name . '：</label><div class="col-sm-9 extraInput"><div class="col-sm-12 extraInput"><input type="hidden" name="' . $kname . '" placeholder="" readonly="readonly" autocomplete="off" class="form-text form-control" id="form-' . $kname . '" value="' . $value . '"/><span>' . $value . '</span></div></div></div>';
        return $html;
    }

    static public function longText($name, $kname, $value = '', $selectData = '', $isNeeded = 0)
    {
        $html = '<div class="form-group"><label class="col-sm-3 control-label" for="form-' . $kname . '">' . $name . '：</label><div class="col-sm-9"><div class="col-sm-12"><input type="text" name="' . $kname . '" placeholder="" class="form-text form-control" id="form-' . $kname . '" value="' . $value . '"/></div><p class=" col-sm-12 error-msg"></p></div></div>';
        return $html;
    }

    static public function unitText($name, $kname, $value = '', $selectData = '', $isNeeded = 0)
    {
        $html = '<div class="form-group"><label class="col-sm-3 control-label" for="form-' . $kname . '">' . $name . '：</label><div class="col-sm-9"><div class="col-sm-12"><div class="input-group col-sm-12"><input type="text" name="' . $kname . '" placeholder="" class="form-text form-control" id="form-' . $kname . '" value="' . $value . '"/><div class="input-group-addon">' . $selectData . '</div></div></div><p class=" col-sm-12 error-msg"></p></div></div>';
        return $html;
    }

    static public function unitTextValue($value, $selectData)
    {

        if ($value !== '') {
            return $value . '&nbsp;' . $selectData;
        } else {
            return '';
        }
    }

    static public function money($name, $kname, $value = '', $selectData = '元', $isNeeded = 0)
    {
        $html = '<div class="form-group"><label class="col-sm-3 control-label" for="form-' . $kname . '">' . $name . '：</label><div class="col-sm-9"><div class="col-sm-12"><div class="input-group col-sm-12"><input type="text" name="' . $kname . '" placeholder="" class="form-text form-control" id="form-' . $kname . '" value="' . $value . '"/><div class="input-group-addon">' . $selectData . '</div></div></div><p class=" col-sm-12 error-msg"></p></div></div>';
        return $html;
    }

    static public function moneyValue($value, $selectData = '元')
    {
        if ($value != '' && $value != 0) {
            return $value . '&nbsp;' . $selectData;
        } else {
            return '';
        }
    }

    static public function groupCheckbox($name, $kname, $value, $selectData, $isNeeded = 0)
    {
        $html = '<div class="form-group"><label class="col-sm-3 control-label" >' . $name . '：</label><div class="col-sm-9"><div class="col-sm-12">';
        $valueArray = explode(',', $value);
        if (count($selectData) > 0) {
            foreach ($selectData as $ul) {
                $ul['key'] = array_unique($ul['key']);
                $keystr = implode(',', $ul['key']);
                $ulHtml = "<p><label class=\"checkbox-inline\" node=\"groupCheckbox\" key=\"{$keystr}\"><strong>{$ul['name']}:</strong></label>\n";

                if (is_array($ul['data'])) {
                    $str = '';
                    foreach ($ul['data'] as $k => $v) {
                        if ($k == '' || $k == 'root') {
                            continue;
                        }
                        $str = '<label class="checkbox-inline">';
                        $checked = '';
                        if (in_array($k, $valueArray)) {
                            $checked = ' checked=\"checked\" ';
                        }
                        $str .= "<input type=\"checkbox\" name=\"{$kname}[]\" $checked  value=\"{$k}\"> {$v}";
                        $str .= '</label>' . "\n";
                        $ulHtml .= $str;
                    }
                }
                $ulHtml .= "</p>\n";
                $html .= $ulHtml;
            }
        }
        $html .= '<p class="col-sm-12 error-msg"></p></div></div></div>' . "\n";
        $html .= "<script>$(document).ready(function(){  $('body').groupCheckbox() ;});</script>" . "\n";
        return $html;
    }

    static public function checkbox($name, $kname, $value, $selectData, $isNeeded = 0)
    {
        $html = '<div class="form-group"><label class="col-sm-3 control-label" >' . $name . '：</label><div class="col-sm-9"><div class="col-sm-12">';
        $valueArray = explode(',', $value);
        if (is_array($selectData)) {
            $str = '';
            foreach ($selectData as $k => $v) {
                if ($k == '' || $k == 'root') {
                    continue;
                }
                $str = '<label class="checkbox-inline">';
                $checked = '';
                if (in_array($k, $valueArray)) {
                    $checked = ' checked=\"checked\" ';
                }
                $str .= "<input type=\"checkbox\" name=\"{$kname}[]\" $checked  value=\"{$k}\"> {$v}";
                $str .= '</label>';
                $html .= $str;
            }
        }

        $html .= '<p class="col-sm-12 error-msg"></p></div></div></div>';
        return $html;
    }

    static public function checkboxValue($value, $selectData)
    {
        $valueArray = explode(',', $value);
        $returnArray = array();
        if (count($valueArray) > 0) {
            foreach ($valueArray as $v) {
                if (isset($selectData[$v])) {
                    $returnArray[] = $selectData[$v];
                } else {
                    $returnArray[] = $v;
                }
            }
        }

        return implode('&nbsp;&nbsp;', $returnArray);
    }

    static public function timestamp($value, $selectData)
    {
        return '';
    }

    static public function timestampValue($value, $selectData)
    {
        return $value;
    }

    static public function html($name, $kname, $value, $selectData, $isNeeded = 0)
    {
        return "<div info=\"{$kname}\">{$value}</div>";
    }

    static public function htmlValue($value, $selectData)
    {
        return $value;
    }

    /**
     * 额外表单项
     * 需要通过AJAX 信息载入或者预载入的方式载入信息
     * 不进入表单提交流程
     * @param $name 名称
     * @param $kname 字段名
     * @param $value 字段值
     * @param $selectData 如果是多选的话传入数组
     * @param $isNeeded  如果是必填项就打星号
     * @return string
     */
    static public function extraInfo($name, $kname, $value, $selectData, $isNeeded = 0)
    {
        $html = '<div class="form-group">';
        $html .= '<label class="col-sm-3 control-label" for="form-' . $kname . '">' . $name . '：</label>';
        $html .= '<div class="col-sm-9"><div class="col-sm-12">';
        $html .= '<input type="text" name="' . $kname . '" placeholder="" autocomplete="off" readOnly="true" class="form-text form-control extraInfo" id="form-' . $kname . '" value="' . $value . '"/></div>';
        $html .= '<p class=" col-sm-12 error-msg"></p></div></div>';
        return $html;
    }

    static public function extraInfoValue($value, $selectData)
    {
        return $value;
    }

    /**
     * 额外表单项
     * 需要通过AJAX 信息载入或者预载入的方式载入信息
     * 不进入表单提交流程
     * 不可编辑
     * @param $name 名称
     * @param $kname 字段名
     * @param $value 字段值
     * @param $selectData 如果是多选的话传入数组
     * @param $isNeeded  如果是必填项就打星号
     * @return string
     */
    static public function extraInput($name, $kname, $value, $selectData, $isNeeded = 0)
    {
        $html = '<div class="form-group">';
        $html .= '<label class="col-sm-3 control-label" for="form-' . $kname . '">' . $name . '：</label>';
        $html .= '<div class="col-sm-9 extraInput"><div class="col-sm-12 extraInput" id="form-' . $kname . '" name="' . $kname . '">';
        $html .= $value . '</div>';
        $html .= '</div></div>';
        return $html;
    }

    static public function extraInputValue()
    {

    }

    /**
     * 时间类参数
     * 来源是time() 生成的整数
     * 输入表单这种几乎用不到
     * @param string $name 名称
     * @param string $kname 字段
     * @param int|string $value 数值 time()
     * @param string $selectData
     * @param int $isNeeded
     * @return string html
     */
    static public function intTimeText($name, $kname, $value = '', $selectData = '', $isNeeded = 0)
    {
        $value = time();
        $html = '<input type="hidden" name="' . $kname . '" placeholder="" autocomplete="off" class="form-text form-control" id="form-' . $kname . '" value="' . $value . '"/>';
        return $html;
    }

    /**
     * 时间类参数
     * 来源是time() 生成的整数
     * 输入表单这种几乎用不到
     * @param int $value time
     * @param string $selectData time 的格式
     * @return string date
     */
    static public function intTimeTextValue($value, $selectData = 'Y-m-d h:i:s')
    {
        if(is_array($selectData)){
            $selectData = 'Y-m-d h:i:s';
        }
        if ($value != '' && $value != 0) {
            return date($selectData, $value);
        } else {
            return '';
        }
    }

}

?>
