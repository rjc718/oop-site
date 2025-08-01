<table 
    <?= isset($id) ? ' id="' . $id . '"' : '' ?>
    <?= isset($classList) ? ' class="' . $classList . '"' : '' ?>
    <?= isset($params) ? ' ' . $params : '' ?>
>
    <tbody>
        <?= $rows ?? '' ?>
    </tbody>
</table>