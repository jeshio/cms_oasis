</div></div>
<!-- конец контента -->

<div class="patMenu">

<!-- правое меню начало -->
<div class="menuRight">
<?php include("menu/rightMenu.php") ?>
</div>
<!-- правое меню конец -->

<div class="normAd">Рекламный блок</div>
</div>
</div>
<div class="clear"></div>
</div>

<!-- Подвал начало -->
<div id="footer">
<div class="paddingContent">
<?php
if($user->seeControlPage)
{
?>
<a href="/control/">Администрирование</a>
<?php
}
?>
<p><font color="blue">&copy; Copyright  by jeshio</font></p>
</div></div>
<!-- Подвал конец -->

</body>
</html>
