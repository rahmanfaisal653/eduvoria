<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportAdmin;

class ReportAdminController extends Controller
{
    public function reportsContentIndex()
    {
        $reports = ReportAdmin::all();
        return view('admin.reports_content', compact('reports'));
    }

    public function create()
    {
        return view('componentsAdmin.add-report-modal');
    }

    public function store(Request $request)
    {
        ReportAdmin::create([
            'type' => $request->type,
            'reported_by' => $request->reported_by,
            'description' => $request->description,
            'priority' => $request->priority,
            'content_summary' => $request->content_summary,
        ]);

        return redirect()->route('admin.reports');
    }

    public function edit($id)
    {
        $report = ReportAdmin::findOrFail($id);
        return view('componentsAdmin.edit-reports-modal', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $report = ReportAdmin::findOrFail($id);
        $report->update([
            'type' => $request->type,
            'reported_by' => $request->reported_by,
            'description' => $request->description,
            'priority' => $request->priority,
            'content_summary' => $request->content_summary,
        ]);

        return redirect()->route('admin.reports');
    }

    public function destroy($id)
    {
        $report = ReportAdmin::findOrFail($id);
        $report->delete();

        return redirect()->route('admin.reports');
    }
}
