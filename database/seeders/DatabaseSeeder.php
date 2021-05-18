<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('currencies')->insert(
            array(
                ['name' => 'Syrian Pound', 'code' => "SYP", "sign" => "ل.س"],
                ['name' => 'United States Dollar', 'code' => "USD", 'sign' => "$"],
            ),
        );
        $this->seedAccountTypes();
        $this->seedExpenseCategories();
    }
    public function seedAccountTypes()
    {
        $defaultAccountTypes = array(
            'أصول', 'التزامات', 'حقوق الملكية', 'دخل', 'نفقات'
        );
        foreach ($defaultAccountTypes as $type) {
            DB::table('account_types')->insert([
                'name' => $type,
            ]);
        }
        $this->seedAccounts();
    }

    public function seedExpenseCategories()
    {
        $rows = [
            [
                "name" => "Advertising",
                "id" => 4861939,
                "parent_id" => null
            ],
            [
                "name" => "Car & Truck Expenses",
                "id" => 4861941,
                "parent_id" => null
            ],
            [
                "name" => "Contractors",
                "id" => 4861953,
                "parent_id" => null
            ],
            [
                "name" => "Education and Training",
                "id" => 4861955,
                "parent_id" => null
            ],
            [
                "name" => "Employee Benefits",
                "id" => 4861957,
                "parent_id" => null
            ],
            [
                "name" => "Meals & Entertainment",
                "id" => 4861971,
                "parent_id" => null
            ],
            [
                "name" => "Office Expenses & Postage",
                "id" => 4861977,
                "parent_id" => null
            ],
            [
                "name" => "Other Expenses",
                "id" => 4861913,
                "parent_id" => null
            ],
            [
                "name" => "Personal",
                "id" => 4861995,
                "parent_id" => null
            ],
            [
                "name" => "Professional Services",
                "id" => 4861965,
                "parent_id" => null
            ],
            [
                "name" => "Rent or Lease",
                "id" => 4861997,
                "parent_id" => null
            ],
            [
                "name" => "Supplies",
                "id" => 4862007,
                "parent_id" => null
            ],
            [
                "name" => "Travel",
                "id" => 4862009,
                "parent_id" => null
            ],
            [
                "name" => "Utilities",
                "id" => 4862017,
                "parent_id" => null
            ]
        ];


        foreach ($rows as $row) {
            DB::table('expense_categories')->insert($row);
        }
    }

    public function seedParentAccounts()
    {
        $defaultAccounts = array(
            array(
                'name' => 'النقد',
                'account_type' => AccountType::where('name', 'أصول')->first()->id,
                'parent_id' => null,
            ),
            array(
                'name' => 'الحسابات المستحقة',
                'account_type' => AccountType::where('name', 'أصول')->first()->id,
                'parent_id' => null,
            ),
            array(
                'name' => 'أصول ثابتة',
                'account_type' => AccountType::where('name', 'أصول')->first()->id,
                'parent_id' => null,
            ),
            array(
                'name' => 'خصومات مؤجلة',
                'account_type' => AccountType::where('name', 'أصول')->first()->id,
                'parent_id' => null,
            ),
            array(
                'name' => 'حسابات قابلة للدفع',
                'account_type' => AccountType::where('name', 'التزامات')->first()->id,
                'parent_id' => null,
            ),
            array(
                'name' => 'حسابات الضرائب',
                'account_type' => AccountType::where('name', 'التزامات')->first()->id,
                'parent_id' => null,
            ),
            array(
                'name' => 'إيرادات غير مكتسبة',
                'account_type' => AccountType::where('name', 'التزامات')->first()->id,
                'parent_id' => null,
            ),
            array(
                'name' => 'رصيد الموردين',
                'account_type' => AccountType::where('name', 'التزامات')->first()->id,
                'parent_id' => null,
            ),
            array(
                'name' => 'رواتب موظفين',
                'account_type' => AccountType::where('name', 'التزامات')->first()->id,
                'parent_id' => null,
            ),
            array(
                'name' => 'الملكية',
                'account_type' => AccountType::where('name', 'حقوق الملكية')->first()->id,
                'parent_id' => null,
            ),
            array(
                'name' => 'رصيد افتتاحي',
                'account_type' => AccountType::where('name', 'حقوق الملكية')->first()->id,
                'parent_id' => null,
            ),
            array(
                'name' => 'إيرادات',
                'account_type' => AccountType::where('name', 'دخل')->first()->id,
                'parent_id' => null,
            ),
            array(
                'name' => 'ايرادات تحويل عملة',
                'account_type' => AccountType::where('name', 'دخل')->first()->id,
                'parent_id' => null,
            ),
            array(
                'name' => 'كلفة المبيعات',
                'account_type' => AccountType::where('name', 'نفقات')->first()->id,
                'parent_id' => null,
            ),
            array(
                'name' => 'مصاريف تحويل عملة',
                'account_type' => AccountType::where('name', 'نفقات')->first()->id,
                'parent_id' => null,
            ),
            array(
                'name' => 'نفقات العمل',
                'account_type' => AccountType::where('name', 'نفقات')->first()->id,
                'parent_id' => null,
            ),
            array(
                'name' => 'ضرائب مدفوعة',
                'account_type' => AccountType::where('name', 'نفقات')->first()->id,
                'parent_id' => null,
            ),
            array(
                'name' => 'مصاريف الموردين',
                'account_type' => AccountType::where('name', 'نفقات')->first()->id,
                'parent_id' => null,
            ),
            array(
                'name' => 'رواتب موظفين',
                'account_type' => AccountType::where('name', 'نفقات')->first()->id,
                'parent_id' => null,
            )
        );
        foreach ($defaultAccounts as $acc) {
            DB::table('accounts')->insert($acc);
        }
    }

    public function seedAccounts()
    {
        $this->seedParentAccounts();
        $innerAccounts = array(
            array(
                'name' => 'الصندوق',
                'account_type' => Account::where('name', 'النقد')->first()->account_type,
                'parent_id' => Account::where('name', 'النقد')->first()->id,
            ),
            array(
                'name' => 'البنوك',
                'account_type' => Account::where('name', 'النقد')->first()->account_type,
                'parent_id' => Account::where('name', 'النقد')->first()->id,
            ),
        );
        foreach ($innerAccounts as $acc) {
            DB::table('accounts')->insert($acc);
        }

        $defaultChildren = array(
            array(
                'name' => 'صندوق مكتب دمشق',
                'account_type' => Account::where('name', 'الصندوق')->first()->account_type,
                'parent_id' => Account::where('name', 'الصندوق')->first()->id,
            ),

            array(
                'name' => 'صندوق الحقل',
                'account_type' => Account::where('name', 'الصندوق')->first()->account_type,
                'parent_id' => Account::where('name', 'الصندوق')->first()->id,
            ),
            array(
                'name' => 'ارباح الزبائن',
                'account_type' => Account::where('name', 'الحسابات المستحقة')->first()->account_type,
                'parent_id' => Account::where('name', 'الحسابات المستحقة')->first()->id,
            ),
            array(
                'name' => 'البنك السوري التجاري فرع 9',
                'account_type' => Account::where('name', 'البنوك')->first()->account_type,
                'parent_id' => Account::where('name', 'البنوك')->first()->id,
            ),
            array(
                'name' => 'الموردين',
                'account_type' => Account::where('name', 'حسابات قابلة للدفع')->first()->account_type,
                'parent_id' => Account::where('name', 'حسابات قابلة للدفع')->first()->id,
            ),
        );
        foreach ($defaultChildren as $child) {
            DB::table('accounts')->insert(
                $child
            );
        }
        $defaultChildren = [
            array(
                'name' => 'جاري الموردين',
                'account_type' => Account::where('name', 'الموردين')->first()->account_type,
                'parent_id' => Account::where('name', 'الموردين')->first()->id,
            ),
            array(
                'name' => 'جاري الموردين',
                'account_type' => Account::where('name', 'مصاريف الموردين')->first()->account_type,
                'parent_id' => Account::where('name', 'مصاريف الموردين')->first()->id,
            ),
        ];
        foreach ($defaultChildren as $child) {
            DB::table('accounts')->insert(
                $child
            );
        }
    }
}
