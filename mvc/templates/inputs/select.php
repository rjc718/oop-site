<select
    <?= isset($name) ? ' name="' . $name . '"' : '' ?>
    <?= !empty($required) ? ' required' : '' ?>
    <?= isset($id) ? ' id="' . $id . '"' : '' ?>
    <?= isset($classList) ? ' class="' . $classList . '"' : '' ?>
    <?= isset($params) ? ' ' . $params : '' ?>
>
    <?= $options ?? '' ?>
</select>
