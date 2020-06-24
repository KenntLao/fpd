<?php

namespace App;

use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class MenuFilter implements FilterInterface
{
    public function transform($item, Builder $builder)
    {
    	if(isset($item['can']) && is_array($item['can']) )
    	{
    		if (array_intersect($item['can'], $_SESSION['sys_permissions'])) 
    		{
    			return $item;
    		} else {
    			return false;
    		}
    	} else {
    		if (isset($item['can']) && !in_array($item['can'], $_SESSION['sys_permissions']) )
	        {
	            return false;
	        }
    	}
        
        return $item;
    }
}
