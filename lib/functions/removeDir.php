<?php
function removeDir($dir)
{
	if ($objs = glob($dir."/*"))
	{
		foreach($objs as $obj)
		{
			is_dir($obj) ? removeDir($obj) : unlink($obj);
		}
	}
	
	rmdir($dir);
}
?>