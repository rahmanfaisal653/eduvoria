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
        $filePath = null; 
        if ($request->hasFile('foto')) {
            // Simpan file ke storage/app/public/reports (disk 'public')
            $filePath = $request->file('foto')->store('reports', 'public');
        }

        $report = ReportAdmin::findOrFail($id);
        $report->update([
            'type' => $request->type,
            'priority' => $request->priority,
            'description' => $request->description,
            'foto' => $filePath,
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
