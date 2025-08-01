<script 
    type="<?= isset($type) && $type ? $type : 'text/javascript' ?>"
    <?= isset($src) ? ' src="' . $src . '"' : '' ?>
    <?= !empty($async) ? ' async' : '' ?>
    <?= !empty($defer) ? ' defer' : '' ?>
    <?= isset($params) ? ' ' . $params : '' ?>
>
</script>
