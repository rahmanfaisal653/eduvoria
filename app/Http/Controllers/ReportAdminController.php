<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportAdminController extends Controller
{
    public function reportsContentIndex()
    {
        $reports = Report::all();
        $totalReport = Report::count();
        $highPriority = Report::where('priority', 'High')->count();
        $mediumPriority = Report::where('priority', 'Medium')->count();
        $lowPriority = Report::where('priority', 'Low')->count();
        return view('admin.reports_content', compact('reports', 'totalReport', 'highPriority', 'mediumPriority', 'lowPriority'));
    }

    public function edit($id)
    {
        $report = Report::findOrFail($id);
        return view('componentsAdmin.edit-reports-modal', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $filePath = null; 
        if ($request->hasFile('foto')) {
            $filePath = $request->file('foto')->store('reports', 'public');
        }

        $report = Report::findOrFail($id);
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
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->route('admin.reports');
    }
}
