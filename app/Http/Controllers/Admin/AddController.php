<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Add;
use Illuminate\Http\Request;

class AddController extends Controller
{
    public function index()
    {
        $items = Add::latest()->get();
        return view('admin.add.index', compact('items'));
    }

    public function create()
    {
        return view('admin.add.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'link' => 'required|url',
        ]);

        Add::create($request->all());
        return redirect()->route('admin.add.index')->with('success', 'Add created.');
    }

    public function edit($id)
    {
        $add = Add::findOrFail($id);
        return view('admin.add.edit', compact('add'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'link' => 'required|url',
        ]);

        $add = Add::findOrFail($id);

        $add->update($request->all());
        return redirect()->route('admin.add.index')->with('success', 'Add updated.');
    }

    public function destroy($id)
    {
        $add = Add::findOrFail($id);
        $add->delete();
        return redirect()->route('admin.add.index')->with('success', 'Deleted.');
    }
}