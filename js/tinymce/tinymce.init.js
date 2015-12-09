/**
 * Created by shake on 2015/12/9.
 */
$(document).ready(function(){
    tinymce.init({
        selector: '.tinymce',
        menu: {
            edit: {title: 'Edit', items: 'undo redo | cut copy paste | selectall'},
            insert: {title: 'Insert', items: 'media image link | pagebreak'},
            view: {title: 'View', items: 'visualaid'},
            format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
            table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
            tools: {title: 'Tools', items: 'code'}
        },
        plugins : "link image paste pagebreak table contextmenu filemanager table code media autoresize textcolor",
        external_filemanager_path:  admin_url + "filemanager/",
        filemanager_title: "文件管理" ,
        external_plugins: { "filemanager" : admin_url + "filemanager/plugin.min.js"},
        relative_urls : false,//相对URL
        convert_urls: false,//必设属性否则URL地址将对不上
        toolbar: 'code | insertfile undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',// 需在工具栏显示的
        language: 'zh_CN',
    });
})