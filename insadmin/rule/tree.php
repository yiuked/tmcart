<?php
/**
 * Created by PhpStorm.
 * User: shake
 * Date: 2015/11/19
 * Time: 16:42
 */

echo UITreeView::load();
$tree = new UITreeView();
$tree->setData();
echo $tree->draw();


function getTree($resultParents, $resultIds,$id_category = 1)
{
    $children = array();
    if (isset($resultParents[$id_category]) AND sizeof($resultParents[$id_category]))
        foreach ($resultParents[$id_category] as $subcat)
            $children[] = getTree($resultParents, $resultIds,$subcat['id_category']);
    if (!isset($resultIds[$id_category]))
        return false;
    if (count($children) >0 ) {
        return array(
            'id' => $id_category,
            'href'=> 'index.php?rule=tree&id=' . $id_category,
            'text' => $resultIds[$id_category]['name'],
            'nodes' => $children);
    }
    return array(
        'id' => $id_category,
        'href'=> 'index.php?rule=tree&id=' . $id_category,
        'text' => $resultIds[$id_category]['name']
    );
}

function hookDisplay()
{
    $result = Db::getInstance()->ExecuteS('
			SELECT id_category,name,id_parent
			FROM `'._DB_PREFIX_.'category`
			ORDER BY `position` ASC');

    if(!$result)
        return;

    $resultParents = array();
    $resultIds = array();

    foreach ($result as &$row)
    {
        $resultParents[$row['id_parent']][] = &$row;
        $resultIds[$row['id_category']] = &$row;
    }

    $blockCategTree = getTree($resultParents, $resultIds);
    unset($resultParents);
    unset($resultIds);

    return $blockCategTree;
}

$data = hookDisplay();
$json = json_encode($data);
?>
<script>
   var json = '[<?php echo $json; ?>]';
   var $expandibleTree = $('#treeview-expandible').treeview({
    data: json,
    enableLinks: true,
    expandIcon: "glyphicon glyphicon-stop",
    collapseIcon: "glyphicon glyphicon-unchecked",
});
   $expandibleTree.treeview('expandNode', [ expandibleNodes, { levels: levels, silent: $('#chk-expand-silent').is(':checked') }]);
</script>
