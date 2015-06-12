<?php
class CacheFSO extends Cache
{
	public function set($key, $value)
	{
		if(!USE_CACHE)
			return false;
		$path = _TM_FSO_DIR;
		if (file_put_contents($path.$key, serialize($value)))
			return true;
		return false;
	}
	
	public function get($key)
	{
		if(!USE_CACHE)
			return false;

		$path = _TM_FSO_DIR;

		if (!file_exists($path.$key))
		{
			return false;
		}
		$file = file_get_contents($path.$key);
		return unserialize($file);
	}

	public function delete($key, $timeout = 0)
	{
		$path = _TM_FSO_DIR;
		if (!file_exists($path.$key))
			return true;
		if (!unlink($path.$key))
			return false;
		return true;
	}
}
?>