<div class="col s12 xl<?=round(12/$tree_count)?> m6 center-align">
    <?//debug(get_defined_vars())?>
    <a class="collection-item flow-text ajax <?= is_active($route['alias'], [$category['alias']], true)?>" href="/exercises/<?=$category['alias'];?>"><?=$category['name'];?></a>
</div>


