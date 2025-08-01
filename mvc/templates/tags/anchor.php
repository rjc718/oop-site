<a 
    <?= isset($href) ? 'href="' . $href . '"' : '' ?>
    <?= !empty($target) ? ' target="_blank"' : '' ?>
    <?= isset($id) ? ' id="' . $id . '"' : '' ?>
    <?= isset($classList) ? ' class="' . $classList . '"' : '' ?>
    <?= isset($title) ? ' title="' . $title . '"' : '' ?>
    <?= isset($params) ? ' ' . $params : '' ?>
>
    <?= $content ?? '' ?>
</a>
