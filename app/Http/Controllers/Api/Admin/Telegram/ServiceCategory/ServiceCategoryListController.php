<?php

namespace App\Http\Controllers\Api\Admin\Telegram\ServiceCategory;

use App\Http\Controllers\Controller;
use App\Http\Services\Telegram\CategoryService;
use Illuminate\Http\Request;

class ServiceCategoryListController extends Controller
{
    private CategoryService $categoryService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request): mixed
    {
        $parent = $request->get('parentCategory');
        $createData = $request->get('createData');

        $this->categoryService->createCategory($parent, $createData);

        return response()->json([
            'status' => 'success',
            'message' => 'Категория успешно создана'
        ]);
    }

    /**
     * @return mixed
     */
    public function list(): mixed
    {
        list($tree, $treeFlat) = $this->categoryService->getTree();

        return response()->json([
            'status' => 'success',
            'tree' => $tree,
            'treeFlat' => $treeFlat
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function children(Request $request, int $id)
    {
        $children = $this->categoryService->getChildren($id === 1 ? CategoryService::getRoot()->id : $id);
        return response()->json([
            'status' => 'success',
            'children' => $children,
        ]);
    }
}
