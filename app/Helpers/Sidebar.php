<?php

Class Sidebar {
    static public function isCurrentMenu($menuId , $availableMenus )
    {
        if (!is_array($availableMenus)) {
            $availableMenus = [$availableMenus];
        }
        return in_array($menuId, $availableMenus);
    }
}
