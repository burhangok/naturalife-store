<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\CommissionRule;
use Auth;
use Illuminate\Http\Request;

class CommissionRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rules = CommissionRule::with('creator','updater')->orderBy('level')->get();


        return view('affiliatemodule.admin.commissionrules.index', compact('rules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('affiliatemodule.admin.commissionrules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'level' => 'required|integer|unique:commission_rules,level',
            'percentage' => 'required|numeric|between:0,100',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['created_admin_id'] = auth()->guard('admin')->user()->id;

        CommissionRule::create($validated);

        return redirect()->route('admin.affiliatemodule.admin.commissionrules.index')
            ->with('success', 'Komisyon kuralı başarıyla oluşturuldu.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommissionRule $commissionRule)
    {
        return view('affiliatemodule.admin.commissionrules.edit', compact('commissionRule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommissionRule $commissionRule)
    {
        $validated = $request->validate([
            'level' => 'required|integer|unique:commission_rules,level,' . $commissionRule->id,
            'percentage' => 'required|numeric|between:0,100',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['updated_admin_id'] = auth()->guard('admin')->user()->id;

        $commissionRule->update($validated);

        return redirect()->route('admin.affiliatemodule.admin.commissionrules.index')
            ->with('success', 'Komisyon kuralı başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommissionRule $commissionRule)
    {
        $commissionRule->delete();

        return redirect()->route('admin.affiliatemodule.admin.commissionrules.index')
            ->with('success', 'Komisyon kuralı başarıyla silindi.');
    }
}
