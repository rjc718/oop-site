<button
    <?= isset($type) ? ' type="' . $type . '"' : ' type="button"' ?>
    <?= isset($name) ? ' name="' . $name . '"' : '' ?>
    <?= isset($id) ? ' id="' . $id . '"' : '' ?>
    <?= isset($classList) ? ' class="' . $classList . '"' : '' ?>
    <?= isset($params) ? ' ' . $params : '' ?>
>
    <?= isset($text) ? $text : 'Click Me' ?>
</button>
