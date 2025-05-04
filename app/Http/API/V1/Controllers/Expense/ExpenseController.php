<?php

namespace App\Http\API\V1\Controllers\Expense;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Expense\ExpenseRepository;
use App\Http\API\V1\Requests\Expense\StoreExpenseRequest;
use App\Http\API\V1\Requests\Expense\UpdateExpenseRequest;
use App\Http\Resources\Expense\ExpenseResource;
use App\Models\Association;
use App\Models\Expense;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

/**
 * @group Expenses
 * APIs for expense settings
 */
class ExpenseController extends Controller
{
    protected ExpenseRepository $expenseRepository;

    public function __construct(ExpenseRepository $expenseRepository)
    {
        $this->middleware(['auth:sanctum']);
        $this->expenseRepository = $expenseRepository;
        $this->authorizeResource(Expense::class);
    }

    /**
     * Show all expenses
     *
     * This endpoint lets you show all expenses
     *
     * @responseFile storage/responses/expenses/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[association_id] string Field to filter items by association_id.
     * @queryParam sort string Field to sort items by id,value.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->expenseRepository->index();

        return $this->showAll($paginatedData->getData(), ExpenseResource::class, $paginatedData->getPagination());
    }

    /**
     * Show all association expenses
     *
     * This endpoint lets you show all association expenses
     *
     * @responseFile storage/responses/association/expenses/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[association_id] string Field to filter items by association_id.
     * @queryParam filter[orders_count] string Field to filter items by orders_count.
     * @queryParam filter[orders_weight] string Field to filter items by orders_weight.
     * @queryParam filter[containers_count] string Field to filter items by containers_count.
     * @queryParam filter[containers_weight] string Field to filter items by containers_weight.
     * @queryParam filter[weight] string Field to filter items by weight.
     * @queryParam filter[value] string Field to filter items by value.
     * @queryParam filter[status] string Field to filter items by status.
     * @queryParam filter[date_range] string Field to filter items by created_at.
     * @queryParam sort string Field to sort items by id,association_id, orders_count, orders_weight, weight, created_at.
     *
     * @param Association $association
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function getAssociationExpenses(Association $association): JsonResponse
    {
        $this->authorize('indexAssociationExpenses', Expense::class);
        $paginatedData = $this->expenseRepository->indexAssociationExpenses($association);

        return $this->showAll($paginatedData->getData(), ExpenseResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific expense
     *
     * This endpoint lets you show specific expense
     *
     * @responseFile storage/responses/expenses/show.json
     *
     * @param Expense $expense
     * @return JsonResponse
     */
    public function show(Expense $expense): JsonResponse
    {
        return $this->showOne($this->expenseRepository->show($expense), ExpenseResource::class);
    }

    /**
     * Add expense
     *
     * This endpoint lets you add expense
     *
     * @responseFile storage/responses/expenses/store.json
     *
     * @param StoreExpenseRequest $request
     * @return JsonResponse
     */
    public function store(StoreExpenseRequest $request): JsonResponse
    {
        $expense = $this->expenseRepository->store($request->validated());

        return $this->showOne($expense, ExpenseResource::class, __('The expense added successfully'));
    }

    /**
     * Update specific expense
     *
     * This endpoint lets you update specific expense
     *
     * @responseFile storage/responses/expenses/update.json
     *
     * @param UpdateExpenseRequest $request
     * @param Expense $expense
     * @return JsonResponse
     */
    public function update(UpdateExpenseRequest $request, Expense $expense): JsonResponse
    {
        $updatedExpense = $this->expenseRepository->updateWithMeta($expense, $request->validated());

        return $this->showOne($updatedExpense, ExpenseResource::class, __("Expense's information updated successfully"));
    }

    /**
     * Delete specific expense
     *
     * This endpoint lets you delete specific expense
     *
     * @responseFile storage/responses/expenses/delete.json
     *
     * @param Expense $expense
     * @return JsonResponse
     */
    public function destroy(Expense $expense): JsonResponse
    {
        $this->expenseRepository->delete($expense);

        return $this->responseMessage(__('Expense deleted successfully'));
    }
}
