<input
    type="text"
    <?= isset($value) ? ' value="' . $value . '"' : '' ?>
    <?= isset($name) ? ' name="' . $name . '"' : '' ?>
    <?= !empty($required) ? ' required' : '' ?>
    <?= isset($id) ? ' id="' . $id . '"' : '' ?>
    <?= isset($classList) ? ' class="' . $classList . '"' : '' ?>
    <?= isset($params) ? ' ' . $params : '' ?>
/>