<div class="rightMenuContent">
<?php
$cAuth->echoAuth($toAuth);
if($toAuth != 1)
{
?>
<a href="<?=$ba_config->path?>registration">Регистрация</a>
<?php 
}
?>
</div>