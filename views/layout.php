<div id="header">
    <div id="site-title">Openion</div>
    <ul class="menu line" id="main-menu">
        <li><a href="<?=url('/list')?>"><?=_("Bills")?></a></li>
        <li><a href="<?=url('/stats')?>"><?=_("Statistics")?></a></li>
    </ul>

    <ul class="menu line" id="user-menu">
        <li><a href="<?=url('/settings')?>"><?=$data->user->name?></a></li>
        <li><a href="<?=url('/logout')?>"><?=_("Log out")?></a></li>
    </ul>
</div>
<div id="content">
    <?=render($data->page,$data)?>
</div>