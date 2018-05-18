<hr/>
<h4 id="10F">多图片上传</h4>
<pre>请求地址：/Upload/images</pre>
<p>参数说明: 必须是http post  允许 gif|jpg|png 文件大小： 5MB 以内</p>
<table class="table table-hover">
    <thead>
    <tr>
        <th width="150">参数</th>
        <th>说明</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>imagesArray</td>
        <td>http 文件上传上传的字段名 相当于<  input type="file" name="imagesArray[]"/ ></td>

    </tr>

    </tbody>
</table>
<p>返回说明</p>
<pre>{"error":"","data":[{"name":"\/uploads\/2017-03-21\/b35675f036db38b4fbdede1de0bdcf8c.png","sourcename":"\u7b7e\u540d.png"}],"status":true,"csrf_test_name":"bd1557f329d0d943cb0be7f009f61412"}</pre>
