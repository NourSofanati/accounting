<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\FixedAsset;
use App\Models\FixedAssetExpenses;
use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\MaterialSpending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MaterialSpendingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $materialCategory = MaterialCategory::find($request->material_id);
        if (isset($request->asset_id) && $request->asset_id) {
            $asset = FixedAsset::find($request->asset_id);
            $expenseAccount = Account::firstOrCreate([
                'name' => $materialCategory->name,
                'account_type' => AccountType::IS_EXPENSE,
                'parent_id' => $asset->expense_account_id,
            ]);
            $materials = $this->processMaterialFifo($request->spent_qty, $request->material_id, $request->date, $expenseAccount->id);
        } else {
            $expenseAccount = Account::firstOrCreate([
                'name' => 'نفقات مواد',
                'account_type' => AccountType::IS_EXPENSE,
                'parent_id' => null,
            ]);
            $materials = $this->processMaterialFifo($request->spent_qty, $request->material_id, $request->date, $expenseAccount->id);
            Log::info($materials);
        }
        return redirect()->route('material-categories.show', $materialCategory);
    }
    function processMaterialFifo($spent_qty, $material_category_id, $date, $account_spent_on_id)
    {
        $allMaterials =
            Material
            ::where('category_id', $material_category_id)
            ->orderBy('date', 'asc')
            ->orderBy('created_at', 'asc')
            ->get()
            ->filter(function ($m) {
                return $m->remaining_qty > 0;
            });
        $materials = array();
        $totalAvailableAmount = 0;
        $totalRemainingAmount = $spent_qty;
        $totalAmountSpent = 0;
        $count = 0;
        foreach ($allMaterials as $material) {
            $totalAvailableAmount += $material->remaining_qty;
            array_push($materials, $material);
            $count++;
            if ($totalAvailableAmount >= $spent_qty) {
                foreach ($materials as $mat) {
                    if ($mat->remaining_qty >= $totalRemainingAmount) {
                        $totalAmountSpent += $totalRemainingAmount;
                        MaterialSpending::create([
                            'material_id' => $mat->id,
                            'qty_spent' => $totalRemainingAmount,
                            'date' => $date,
                            'account_spent_on_id' => $account_spent_on_id
                        ]);
                        break;
                    } else {
                        $totalRemainingAmount -= $mat->remaining_qty;
                        $totalAmountSpent += $mat->remaining_qty;
                        MaterialSpending::create([
                            'material_id' => $mat->id,
                            'qty_spent' => $mat->remaining_qty,
                            'date' => $date,
                            'account_spent_on_id' => $account_spent_on_id
                        ]);
                    }
                }
                break;
            }
        }
        return $materials;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MaterialSpending  $materialSpending
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialSpending $materialSpending)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MaterialSpending  $materialSpending
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialSpending $materialSpending)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaterialSpending  $materialSpending
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialSpending $materialSpending)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaterialSpending  $materialSpending
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialSpending $materialSpending)
    {
        //
    }
}
