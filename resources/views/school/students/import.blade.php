@extends('school.layouts.school')
@section('title', 'Import Students - School Portal')
@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="font-black text-2xl text-cream">Bulk Import Students</h1>
        <p class="text-muted text-sm font-semibold">{{ $school->name }}</p>
    </div>
    <a href="{{ route('school.students', ['school_id' => $school->id]) }}" class="inline-flex items-center gap-2 bg-white border border-gray-200 text-ink px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-gray-50 transition-all">Back to Students</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <h2 class="font-black text-lg text-ink mb-2">Upload CSV</h2>
        <p class="text-sm text-muted font-semibold mb-6">Upload a CSV file with the following columns: <code class="bg-gray-100 px-2 py-0.5 rounded text-xs">name, email, password, child_name, child_dob, child_gender</code></p>
        <form method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-muted mb-2">CSV File</label>
                    <input type="file" name="csv_file" accept=".csv,.txt" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm">
                </div>
                <button type="submit" class="w-full bg-primary text-white py-3 rounded-xl font-bold text-sm hover:bg-primary/90 transition-all">Import Students</button>
            </div>
        </form>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <h2 class="font-black text-lg text-ink mb-4">CSV Format</h2>
        <div class="bg-gray-50 rounded-xl p-4 text-xs font-mono leading-relaxed text-muted whitespace-pre">name,email,password,child_name,child_dob,child_gender
John Parent,john@example.com,pass123,Child One,2016-03-15,male
Jane Parent,jane@example.com,pass456,Child Two,2018-07-22,female
... </div>
        <div class="mt-6 p-4 rounded-xl bg-amber-50 border border-amber-200">
            <div class="font-bold text-sm text-amber-700 mb-1">Notes</div>
            <ul class="text-xs text-amber-600 space-y-1">
                <li>• If the parent email already exists, a new child is added to their account</li>
                <li>• Child PIN defaults to last 4 digits of DOB (e.g., 0315)</li>
                <li>• Gender: male, female, or prefer_not_to_say</li>
                <li>• Max file size: 2MB</li>
            </ul>
        </div>
    </div>
</div>
@endsection
