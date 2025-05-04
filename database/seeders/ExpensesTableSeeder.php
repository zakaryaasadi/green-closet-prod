<?php

namespace Database\Seeders;

use App\Enums\ExpenseStatus;
use App\Models\Association;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $association_id = Association::whereUserId(User::whereEmail('association@green-closet.com')->first()->id)->first()->id;

        $this->createExpense(5, 52, 15, 15, 11, 600, '2022-10-10 10:00:00', ExpenseStatus::PAYED, $association_id);

        $this->createExpense(10, 35, 15, 15, 13, 633, '2022-12-10 10:00:00', ExpenseStatus::PROCESSING, $association_id);

        $this->createExpense(2, 15, 25, 25, 40, 644, '2022-09-10 10:00:00', ExpenseStatus::PAYED, $association_id);

        $this->createExpense(3, 55, 35, 53, 50, 611, '2022-08-10 10:00:00', ExpenseStatus::PROCESSING, $association_id);

        $this->createExpense(44, 65, 45, 45, 60, 622, '2022-07-10 10:00:00', ExpenseStatus::PAYED, $association_id);

        $this->createExpense(44, 57, 15, 55, 70, 655, '2022-06-10 10:00:00', ExpenseStatus::PROCESSING, $association_id);

        $this->createExpense(555, 58, 55, 65, 20, 666, '2022-05-10 10:00:00', ExpenseStatus::PAYED, $association_id);

        $this->createExpense(56, 51, 15, 57, 10, 100, '2022-09-10 10:00:00', ExpenseStatus::PROCESSING, $association_id);

        $this->createExpense(51, 53, 65, 58, 10, 250, '2022-10-10 10:00:00', ExpenseStatus::PAYED, $association_id);

        $this->createExpense(52, 5, 15, 59, 10, 350, '2022-11-10 10:00:00', ExpenseStatus::PROCESSING, $association_id);
    }

    public function createExpense($containers_count, $orders_count, $orders_weight, $containers_weight, $weight, $value, $date, $status, $association_id)
    {
        Expense::create([
            'containers_count' => $containers_count,
            'orders_count' => $orders_count,
            'orders_weight' => $orders_weight,
            'containers_weight' => $containers_weight,
            'weight' => $weight,
            'value' => $value,
            'date' => $date,
            'status' => $status,
            'association_id' => $association_id,
        ]);

    }
}
