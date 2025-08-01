<input
    type="radio"
    <?= isset($value) ? ' value="' . $value . '"' : '' ?>
    <?= isset($name) ? ' name="' . $name . '"' : '' ?>
    <?= !empty($required) ? ' required' : '' ?>
    <?= !empty($checked) ? ' checked' : '' ?>
    <?= isset($id) ? ' id="' . $id . '"' : '' ?>
    <?= isset($classList) ? ' class="' . $classList . '"' : '' ?>
    <?= isset($params) ? ' ' . $params : '' ?> 
/>