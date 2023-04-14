<?php


namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Routing\Controller as BaseController;

class MenuController extends BaseController
{
    /* TODO: complete getMenuItems so that it returns a nested menu structure from the database

     */

    public function getMenuItems()
    {
        $menuItems = MenuItem::whereNull('parent_id')->get();
        $result = [];

        foreach ($menuItems as $menuItem) {
            $item = $menuItem->toArray();
            $item['children'] = $this->getChildren($menuItem);
            $result[] = $item;
        }

        return $result;
    }

    private function getChildren($menuItem)
    {
        $menuItems = $menuItem->children()->get();

        if ($menuItems->isEmpty()) {
            return [];
        }

        $result = [];

        foreach ($menuItems as $menuItem) {
            $item = $menuItem->toArray();
            $item['children'] = $this->getChildren($menuItem);
            $result[] = $item;
        }

        return $result;
    }
}
