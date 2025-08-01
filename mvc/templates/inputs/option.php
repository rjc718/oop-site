<option
    <?= isset($value) ? ' value="' . $value . '"' : '' ?>
    <?= !empty($selected) ? ' selected' : '' ?>
    <?= isset($params) ? ' ' . $params : '' ?>
>
    <?= $text ?? '' ?>
</option>