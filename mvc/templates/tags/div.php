<div 
    <?= isset($id) ? ' id="' . $id . '"' : '' ?>
    <?= isset($classList) ? ' class="' . $classList . '"' : '' ?>
    <?= isset($params) ? ' ' . $params : '' ?>
>
    <?= $content ?? '' ?>
</div>
