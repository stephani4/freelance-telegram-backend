<?php

namespace App\Http\Services\Telegram;

use App\Models\ServiceCategory;
use Illuminate\Support\Str;

class CategoryService
{
    private ServiceCategory $serviceCategory;

    public function __construct()
    {
        $this->serviceCategory = new ServiceCategory();
    }

    /**
     * @param array $categoryData
     * @return void
     */
    public function createRoot(array $categoryData) : void
    {
        $category = $this->serviceCategory->create([
            'name' => $categoryData['name'],
            'slug' => empty($categoryData['slug']) ? Str::slug($categoryData['name']) : $categoryData['slug'],
            'show' => 0,
        ]);

        $category->saveAsRoot();
    }

    /**
     * @param int $parentCategory
     * @param array $data
     * @return void
     */
    public function createCategory(int $parentCategory, array $data) : void
    {
        $parent = $this->serviceCategory->where('id', '=', $parentCategory)->first();
        $parent->children()->create([
            'name' => $data['name'],
            'slug' => empty($data['slug']) ? Str::slug($data['name']) : $data['slug'],
            'show' => $data['show']
        ]);
    }

    /**
     * Получение дерева категорий услуг
     *
     * @return mixed
     */
    public function getTree()
    {
        $categories = ServiceCategory::get();

        $tree = $categories->toTree();
        $treeFlat = $categories->toFlatTree();

        return [$tree, $treeFlat];
    }

    /**
     * @param int $parentID
     * @return void
     */
    public function getChildren(int $parentID)
    {
        $parent = $this->serviceCategory->find($parentID);
        return $parent->children;
    }

    /**
     * @return mixed
     */
    public static function getRoot()
    {
        return ServiceCategory::where('slug', 'root')->first();
    }
}
